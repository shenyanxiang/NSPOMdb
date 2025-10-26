import sys
import argparse
from package.pred_plasmid import _plasmid
from package.pred_chr import _chr
from package.pred_meta import _meta
from package.pred_contig import _contig
from typing import Callable

# Define constants for genome types to avoid hardcoding strings
GENOME_TYPES = {
    'Plasmid': _plasmid,
    'Chromosome': _chr,
    'Contig': _contig,
    'Meta': _meta,
}

def validate_genome_type(value: str) -> str:
    """Validate genome type and raise an error if invalid."""
    if value not in GENOME_TYPES:
        raise argparse.ArgumentTypeError(
            f"Invalid genome type '{value}'. Choose from: {', '.join(GENOME_TYPES.keys())}."
        )
    return value

def main():
    parser = argparse.ArgumentParser(
        description='Prediction of antibiotic resistance genes and virulence factors in bacteria or fungi genomes',
    )

    parser.add_argument(
        '-i', '--input', type=str, required=True,
        help='FASTA format file'
    )
    parser.add_argument(
        '-t', '--type', type=validate_genome_type, required=True,
        help='Genome Type: Chromosome/Plasmid/Contig/Meta'
    )
    parser.add_argument(
        '-o', '--output', type=str, required=True,
        help='Output directory, just need to provide the name, the program will create a directory with this name in the output directory'
    )

    args = parser.parse_args()

    # Get the appropriate function for the genome type
    process_function: Callable[[str, str, str], None] = GENOME_TYPES[args.type]

    # Call the function
    if args.type in {'Plasmid', 'Chromosome'}:
        process_function(args.output, args.input, 'fa')
    else:
        process_function(args.output, args.input)

    print(f"{args.output} done!!")

if __name__ == '__main__':
    main()