import argparse
from package.pred_fungi import _fungi

def main():
    parser = argparse.ArgumentParser(
        description='Prediction of antibiotic resistance genes and virulence factors in bacteria or fungi genomes',
    )

    parser.add_argument(
        '-i', '--input', type=str, required=True,
        help='FASTA format file'
    )
    parser.add_argument(
        '-t', '--type', required=True,
        help='File type: faa/gbk'
    )
    parser.add_argument(
        '-o', '--output', type=str, required=True,
        help='Output directory, just need to provide the name, the program will create a directory with this name in the output directory'
    )
    parser.add_argument(
        '--seq_score', type=float, default=100,
        help='Minimum full sequence score threshold for HMMER results (default: 100)'
    )
    parser.add_argument(
        '--domain_score', type=float, default=50,
        help='Minimum domain score threshold for HMMER results (default: 50)'
    )
    parser.add_argument(
        '--ha_value', type=float, default=0.64,
        help='BLASTp Ha-value threshold (default: 0.64)'
    )

    args = parser.parse_args()
    _fungi(args.input, args.type, args.output, 
           args.seq_score, args.domain_score, args.ha_value)

if __name__ == '__main__':
    main()