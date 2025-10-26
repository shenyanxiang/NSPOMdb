import os
import subprocess
from package.utils import get_param

# Load parameters
param = get_param()
workdir = param[0]
soft_dir = param[1]
rep_ident = param[5]
rep_cov = param[6]


def get_cds_from_gff(runID):
    """
    Extract CDS intervals and strand information from a Prokka .gff file.
    :param runID: The identifier for the current genome run.
    :return: List of CDS intervals in the format [(start, end, strand)].
    """
    gff_file = os.path.join('./jobs', runID, f"{runID}.gff")
    cds_intervals = []

    # Check if the .gff file exists
    if not os.path.exists(gff_file):
        raise FileNotFoundError(f"GFF file not found: {gff_file}")

    # Parse the .gff file
    with open(gff_file, "r") as file:
        for line in file:
            if line.startswith("#"):
                continue  # Skip comments
            parts = line.strip().split('\t')
            if len(parts) < 8:
                continue  # Skip malformed lines
            feature_type = parts[2]
            if feature_type == "CDS":
                start, end = int(parts[3]), int(parts[4])
                strand = parts[6]  # Strand information ('+' or '-')
                cds_intervals.append((start, end, strand))
    return cds_intervals

def get_cds_from_gff_contigs(runID):
    """
    Extract CDS intervals and strand information from a Prokka .gff file for contigs.
    :param runID: The identifier for the current genome run.
    :return: List of CDS intervals in the format [(start, end, strand)].
    """
    gff_file = os.path.join('./jobs', runID, f"{runID}.gff")
    cds_intervals = []

    # Check if the .gff file exists
    if not os.path.exists(gff_file):
        raise FileNotFoundError(f"GFF file not found: {gff_file}")

    # Parse the .gff file
    with open(gff_file, "r") as file:
        for line in file:
            if line.startswith("#"):
                continue  # Skip comments
            parts = line.strip().split('\t')
            if len(parts) < 8:
                continue  # Skip malformed lines
            feature_type = parts[2]
            if feature_type == "CDS":
                contig_id = parts[0]  # Contig ID
                start, end = int(parts[3]), int(parts[4])
                strand = parts[6]  # Strand information ('+' or '-')
                cds_intervals.append((contig_id, start, end, strand))
    return cds_intervals

def overlap(interval1, interval2, threshold=0.8):
    """
    Check if two intervals overlap significantly (>80%).
    :param interval1: First interval as [start, end].
    :param interval2: Second interval as [start, end].
    :param threshold: Overlap threshold (default 80%).
    :return: True if overlap is significant, False otherwise.
    """
    start = max(interval1[0], interval2[0])
    end = min(interval1[1], interval2[1])
    if end > start:
        overlap_fraction = (end - start) / (interval2[1] - interval2[0])
        return overlap_fraction > threshold
    return False


def run_abricate(infile):
    """
    Run abricate to predict ARGs from the input genome.
    :param infile: Path to the input genome file.
    :return: List of ARGs with their positions and details.
    """
    cmd = [
        os.path.join(soft_dir, "abricate"),
        "--db", "resfinderf",
        "--minid", str(rep_ident),
        "--mincov", str(rep_cov),
        "--quiet", infile
    ]
    env = os.environ.copy()
    env["PATH"] = "/public/shenyx/software/miniconda3/envs/VRprofile2/bin:" + env["PATH"]

    try:
        # Run the command and capture output
        result = subprocess.run(cmd, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True, check=True, env = env)
        args = []
        args_contig = []
        for line in result.stdout.splitlines():
            if not line.startswith('#FILE'):
                parts = line.strip().split('\t')
                ID, start, end, gene, description = parts[1], int(parts[2]), int(parts[3]), parts[13], parts[14]
                args.append([start, end, f"{gene}\t{description}~ARG"])
                args_contig.append([ID, start, end, f"{gene}\t{description}~ARG"])
        return args, args_contig
    except subprocess.CalledProcessError as e:
        raise RuntimeError(f"Abricate failed: {e.stderr}")


def arg_predict(infile, runID):
    """
    Predict ARGs and filter by overlap with CDS.
    :param infile: Path to the input genome file.
    :param runID: The identifier for the current genome run.
    :return: List of ARGs overlapping with CDS.
    """
    # Run abricate to get ARG predictions
    args, args_contig = run_abricate(infile)

    # Extract CDS intervals from the .gff file
    cds_intervals = get_cds_from_gff(runID)

    # Filter ARGs by significant overlap with CDS
    result = []
    for start, end, gene_info in args:
        for cds_start, cds_end, strand in cds_intervals:
            if overlap([start, end], [cds_start, cds_end]):
                result.append([cds_start, cds_end, strand, gene_info])
    return result

def arg_predict_contigs(infile, runID):
    """
    Predict ARGs for contigs and filter by overlap with CDS.
    :param infile: Path to the input genome file.
    :param runID: The identifier for the current genome run.
    :return: List of ARGs overlapping with CDS for contigs.
    """
    # Run abricate to get ARG predictions
    args, args_contig = run_abricate(infile)

    # Extract CDS intervals from the .gff file
    cds_intervals = get_cds_from_gff_contigs(runID)

    # Filter ARGs by significant overlap with CDS
    result = []
    for ID, start, end, gene_info in args_contig:
        for contig_id, cds_start, cds_end, strand in cds_intervals:
            if overlap([start, end], [cds_start, cds_end]) and contig_id == ID:
                result.append([ID, cds_start, cds_end, strand, gene_info])
    return result


if __name__ == '__main__':
    infile = '/path/to/input.fa'
    runID = 'example_run'

    try:
        # Run ARG prediction
        predictions = arg_predict(infile, runID)
        for prediction in predictions:
            print(prediction)
    except Exception as e:
        print(f"Error: {e}")