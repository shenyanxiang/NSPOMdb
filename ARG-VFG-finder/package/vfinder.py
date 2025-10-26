import os
import sys
from Bio import SeqIO
from Bio.SeqUtils import GC
from Bio.Blast.Applications import NcbiblastpCommandline
from package.utils import get_param
import subprocess
import logging

# Load parameters
param = get_param()
workdir = param[0]
soft_dir = param[1]

# Define directories and database
final_dir = os.path.join(workdir, 'jobs')
VF_Database = os.path.join(workdir, 'data', 'myVF')


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


def extract_cds_locations(gbk_file):
    """
    Extract CDS locations and strand information from a GenBank file.
    :param gbk_file: Path to the GenBank (.gbk) file.
    :return: Dictionary mapping locus tags to CDS locations and strand.
    """
    if not os.path.exists(gbk_file):
        raise FileNotFoundError(f"GenBank file not found: {gbk_file}")
    
    bed_dict = {}
    with open(gbk_file, "r") as gbb:
        seq_record = SeqIO.read(gbb, "genbank")
        for seq_feature in seq_record.features:
            if seq_feature.type == "CDS" and 'translation' in seq_feature.qualifiers:
                if 'locus_tag' in seq_feature.qualifiers:
                    locus_tag = seq_feature.qualifiers['locus_tag'][0]
                    locations = [
                        (int(str(part.start).replace('<', '')) + 1, int(str(part.end).replace('<', '')))
                        for part in seq_feature.location.parts
                    ]
                    strand = "+" if seq_feature.location.strand == 1 else "-"  # Extract strand information
                    bed_dict[locus_tag] = (locations[0], strand)  # Include strand info
                else:
                    raise ValueError("Missing 'locus_tag' in GenBank CDS feature.")
    return bed_dict


def vf_predict(runID):
    """
    Predict virulence factors (VFs) for a given genome run ID.
    :param runID: The identifier for the current genome run.
    :return: List of predicted VFs with locations, strand, and descriptions.
    """
    gb_file = os.path.join(os.path.join(final_dir, runID), f"{runID}.gbk")
    faa_file = os.path.join(os.path.join(final_dir, runID), f"{runID}.faa")
    vf_output = os.path.join(os.path.join(final_dir, runID), f"VF_{runID}")

    # Ensure required files exist
    if not os.path.exists(faa_file):
        raise FileNotFoundError(f"Protein FASTA file not found: {faa_file}")

    # Extract CDS locations from the GenBank file
    cds_locations = extract_cds_locations(gb_file)

    # Run BLASTP to find matches in the VF database
    run_blastp(faa_file, VF_Database, vf_output)

    # Filter BLASTP results
    filtered_results = filter_blast_results(vf_output)

    # Map BLAST results back to CDS locations
    vf_list = []
    for result in filtered_results:
        locus_tag = result[0]
        if locus_tag in cds_locations:
            (start, end), strand = cds_locations[locus_tag]
            vf = result[1].split('~~~')[1] if '~~~' in result[1] else result[1]
            best_hit = result[13]
            evalue = result[10]
            vf_list.append([vf, start, end, strand, best_hit, evalue])
        else:
            print(f"Warning: Locus tag {locus_tag} not found in GenBank CDS features.")

    return vf_list

def parse_gff_for_locus(gff_file):
    """
    解析prokka GFF，返回locus_tag到(contig, start, end, strand)的映射dict
    """
    locus_info = {}
    with open(gff_file, 'r') as f:
        for line in f:
            if line.startswith('#'): continue
            parts = line.strip().split('\t')
            if len(parts) < 9: continue
            contig = parts[0]
            feature_type = parts[2]
            if feature_type != 'CDS': continue
            start = int(parts[3])
            end = int(parts[4])
            strand = parts[6]
            attributes = parts[8]
            locus_tag = None
            for attr in attributes.split(';'):
                if attr.startswith('locus_tag='):
                    locus_tag = attr.split('=')[1]
                    break
            if locus_tag:
                locus_info[locus_tag] = (contig, start, end, strand)
    return locus_info

def vf_predict_contigs(infile, runID):
    """
    Predict virulence factors (VFs) for a given contig FASTA file.
    Returns a list of [contig_id, start, end, strand, vf, best_hit, evalue].
    """
    final_dir = os.path.join(workdir, 'jobs', runID)

    faa_file = os.path.join(final_dir, f"{runID}.faa")
    gff_file = os.path.join(final_dir, f"{runID}.gff")
    vf_output = os.path.join(final_dir, f"VF_{runID}")
    vf_list = []

    if not os.path.exists(faa_file):
        raise FileNotFoundError(f"Protein FASTA file not found: {faa_file}")
    if not os.path.exists(gff_file):
        raise FileNotFoundError(f"GFF file not found: {gff_file}")

    # 解析GFF
    locus_dict = parse_gff_for_locus(gff_file)

    # Run BLASTP to find matches in the VF database
    run_blastp(faa_file, VF_Database, vf_output)
    # Filter BLASTP results
    filtered_results = filter_blast_results(vf_output)
    # Write filtered results to file
    filtered_results_file = os.path.join(final_dir, f"Filtered_blast_{runID}.txt")
    with open(filtered_results_file, 'w') as f:
        for result in filtered_results:
            f.write('\t'.join(result) + '\n')
    # Map BLAST results to VFs
    for result in filtered_results:
        locus_tag = result[0]
        vf = result[1].split('~~~')[1] if '~~~' in result[1] else result[1]
        best_hit = result[13]
        evalue = result[10]
        if locus_tag in locus_dict:
            contig_id, start, end, strand = locus_dict[locus_tag]
        else:
            contig_id, start, end, strand = ("NA", 0, 0, "+")
        vf_list.append([contig_id, start, end, strand, vf, best_hit, evalue])
    return vf_list


if __name__ == '__main__':
    runID = 'AP014651.1'
    try:
        vf_predictions = vf_predict(runID)
        for prediction in vf_predictions:
            print(prediction)
    except Exception as e:
        print(f"Error: {e}")