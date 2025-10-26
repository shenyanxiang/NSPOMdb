import os
import json, shutil
from Bio import SeqIO
from package.utils import *
from Bio.Blast.Applications import NcbiblastpCommandline

def run_blastp(query_faa, vf_database, output_file):
    """
    Run BLASTP to compare protein sequences against the virulence factor database.
    :param query_faa: Path to the input .faa file.
    :param vf_database: Path to the virulence factor database.
    :param output_file: Path to store BLASTP results.
    """
    try:
        blastp_cline = NcbiblastpCommandline(
            cmd='/public/shenyx/software/ncbi-blast-2.10.0+/bin/blastp',
            query=query_faa,
            db=vf_database,
            evalue=0.0001,
            num_threads=30,
            max_hsps=1,
            num_descriptions=1,
            num_alignments=1,
            outfmt="6 std qlen stitle",
            out=output_file
        )
        blastp_cline()
    except Exception as e:
        raise RuntimeError(f"BLASTP execution failed: {e}")
    
def filter_blast_results(blast_output, threshold=0.64):
    """
    Filter BLASTP results based on alignment coverage and identity.
    :param blast_output: Path to the BLASTP output file.
    :param threshold: Minimum alignment quality threshold.
    :return: List of filtered results.
    """
    filtered_results = []
    if not os.path.exists(blast_output):
        raise FileNotFoundError(f"BLAST output file not found: {blast_output}")
    
    with open(blast_output, 'r') as file:
        for line in file:
            fields = line.strip().split('\t')
            alignment_coverage = (int(fields[3]) / int(fields[12])) * (float(fields[2]) / 100)
            if alignment_coverage >= threshold:
                filtered_results.append(fields)
    return filtered_results

def run_hmmsearch(query_faa, database, output_file):
    """
    Run HMMER's hmmsearch to find matches in the specified database.
    :param query_faa: Path to the input .faa file.
    :param database: Path to the HMM database.
    :param output_file: Path to store HMMER results.
    """
    try:
        hmmsearch_cline = f"/public/shenyx/software/miniconda3/envs/VRprofile2/bin/hmmsearch --tblout {output_file} -E 1e-5 {database} {query_faa}"
        os.system(hmmsearch_cline)
    except Exception as e:
        raise RuntimeError(f"HMMER execution failed: {e}")
    
def filter_hmm_results(hmm_output, threshold1=100, threshold2=50):
    """
    Filter HMMER results based on alignment coverage and identity.
    :param hmm_output: Path to the HMMER output file (tbl format).
    :param threshold1: Minimum full sequence score threshold (default: 100).
    :param threshold2: Minimum domain score threshold (default: 50).
    :return: List of filtered results (each result is a list of columns).
    """
    filtered_results = []
    if not os.path.exists(hmm_output):
        raise FileNotFoundError(f"HMMER output file not found: {hmm_output}")

    with open(hmm_output) as f:
        for line in f:
            if line.startswith("#") or not line.strip():
                continue
            fields = line.strip().split()
            try:
                full_seq_score = float(fields[5])
                domain_score = float(fields[8])
            except (IndexError, ValueError):
                continue
            if full_seq_score > threshold1 and domain_score > threshold2:
                filtered_results.append(fields)
    return filtered_results
    

def vf_predict(runID, VF_Database, final_dir, ha_value=0.64):
    """
    Predict virulence factors (VFs) for a given run ID.
    :param runID: The identifier for the current genome run.
    :return: List of predicted VFs with locations, strand, and descriptions.
    """
    faa_file = os.path.join(final_dir,  f"{runID}.faa")
    vf_output = os.path.join(final_dir,  f"VF_{runID}")
    # Ensure required files exist
    if not os.path.exists(faa_file):
        raise FileNotFoundError(f"Protein FASTA file not found: {faa_file}")

    # Run BLASTP to find matches in the VF database
    run_blastp(faa_file, VF_Database, vf_output)

    # Filter BLASTP results
    filtered_results = filter_blast_results(vf_output, threshold=ha_value)

    vf_list = []
    for result in filtered_results:
        locus_tag = result[0].split('|')[0]
        protein_id = result[0].split('|')[1].split(' ')[0] if '|' in result[0].split(' ')[0] else ''
        uniprot_id = result[13].split('|')[0]
        vf = result[13].split('|')[1]
        disease_host = result[13].split('|')[2]
        disease = result[13].split('|')[-1]
        vf_list.append([vf, uniprot_id, locus_tag, protein_id, disease_host, disease])
        
    return vf_list

def arg_predict(runID, ARG_Database, final_dir, seq_score=100, domain_score=50):
    """
    Predict virulence factors (VFs) for a given run ID.
    :param runID: The identifier for the current genome run.
    :return: List of predicted VFs with locations, strand, and descriptions.
    """
    faa_file = os.path.join(final_dir, f"{runID}.faa")
    vf_output = os.path.join(final_dir, f"ARG_{runID}")
    # Ensure required files exist
    if not os.path.exists(faa_file):
        raise FileNotFoundError(f"Protein FASTA file not found: {faa_file}")

    # Run HMMER to find matches in the ARG database
    run_hmmsearch(faa_file, ARG_Database, vf_output)

    # Filter HMMER results
    filtered_results = filter_hmm_results(vf_output, seq_score, domain_score)

    arg_list = []
    for result in filtered_results:
        locus_tag = result[0].split('|')[0]
        protein_id = result[0].split('|')[1].split(' ')[0] if '|' in result[0].split(' ')[0] else ''
        drug_class = result[2]
        arg_list.append([locus_tag, protein_id, drug_class])

    return arg_list

def _fungi(infile, type, runID, seq_score=100, domain_score=50, ha_value=0.64):
    # Step 1: Get genome information
    param = get_param()
    workdir = param[0]
    tag_dir = os.path.join(workdir, 'Tag')
    final_dir = os.path.join(workdir, 'jobs', runID)
    if not os.path.exists(final_dir):
        os.makedirs(final_dir)
    VF_Database = os.path.join(workdir, 'data', 'DFVF')
    ARG_Database = os.path.join(workdir, 'data', 'ResFungi.hmm')

    # Define output files
    all_arg = os.path.join(final_dir, 'Antibiotic_Resistance_Gene.txt')
    all_arg_json = os.path.join(final_dir, 'Antibiotic_Resistance_Gene.json')
    all_vf = os.path.join(final_dir, 'Virulence_Factor.txt')
    all_vf_json = os.path.join(final_dir, 'Virulence_Factor.json')

    if type == 'gbk':
        faafile = os.path.join(final_dir, f"{runID}.faa")
        with open(faafile, 'w') as faafh:
            for record in SeqIO.parse(infile, 'genbank'):
                for feature in record.features:
                    if feature.type == 'CDS':
                        if 'translation' in feature.qualifiers:
                            protein_seq = feature.qualifiers['translation'][0]
                            locus_tag = feature.qualifiers.get('locus_tag', ['unknown'])[0]
                            protein_id = feature.qualifiers.get('protein_id', [''])[0]
                            if protein_id:
                                header = f">{locus_tag}|{protein_id}\n"
                            else:
                                header = f">{locus_tag}\n"
                            faafh.write(f"{header}{protein_seq}\n")
        infile = faafile
    elif type == 'faa':
        faafile = infile

    # Step 2: Run BLASTP against the virulence factor database
    vf_list = vf_predict(runID, VF_Database, final_dir)
    
    # Step 3: Generate VF prediction result file (TXT and JSON)
    vf_json_data = []
    with open(all_vf, 'w') as vf_output:
        vf_header = 'VF\tUniprot_id\tLocus_tag\tProtein_id\tDisease_host\tDisease'
        vf_output.write(vf_header + '\n')
        for vf, uniprot_id, locus_tag, protein_id, disease_host, disease in vf_list:
            vf_output.write('\t'.join([vf, uniprot_id, locus_tag, protein_id, disease_host, disease]) + '\n')

            # Append to JSON data
            vf_json_data.append({
                "VF_symbol": vf,
                "Uniprot_id": uniprot_id,
                "Locus_tag": locus_tag,
                "Protein_id": protein_id,
                "Disease_host": disease_host,
                "Disease": disease
            })
    # Write VF JSON data
    with open(all_vf_json, 'w') as vf_json_output:
        json.dump(vf_json_data, vf_json_output, indent=4)

    arg_list = arg_predict(runID, ARG_Database, final_dir, seq_score, domain_score)
    # Step 4: Generate ARG prediction result file (TXT and JSON)
    arg_json_data = []
    with open(all_arg, 'w') as arg_output:
        arg_header = 'Locus_tag\tProtein_id\tDrug_class'
        arg_output.write(arg_header + '\n')
        for locus_tag, protein_id, drug_class in arg_list:
            arg_output.write('\t'.join([locus_tag, protein_id, drug_class]) + '\n')

            # Append to JSON data
            arg_json_data.append({
                "Locus_tag": locus_tag,
                "Protein_id": protein_id,
                "Drug_class": drug_class
            })
    # Write ARG JSON data
    with open(all_arg_json, 'w') as arg_json_output:
        json.dump(arg_json_data, arg_json_output, indent=4)

    # Step 5: Create a tag file to indicate the start of analysis
    tag_file = os.path.join(tag_dir, f"f_{runID}")
    if not os.path.exists(tag_file):
        open(tag_file, "w").close()

if __name__ == '__main__':
    gbff_dir = '/public/shenyx/workspace/fungi_genomes_genbank'

    for gbff_file in os.listdir(gbff_dir):
        file_path = os.path.join(gbff_dir, gbff_file)
        runID = os.path.splitext(os.path.basename(gbff_file))[0]
        print(f"Processing {gbff_file} as runID {runID} ...")
        _fungi(file_path, 'gbk', runID)
    # file_path = './test/GCA_000002655.1.gbff'
    # runID = 'Example_Fungi'
    # _fungi(file_path, 'gbk', runID)