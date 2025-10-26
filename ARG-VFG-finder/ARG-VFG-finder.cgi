#!/public/shenyx/software/miniconda3/envs/VRprofile2/bin/python
# -*- coding: utf-8 -*-

import os
import sys
import shutil
from Bio import SeqIO
import subprocess
import cgi
import cgitb
from package.utils import get_param

# cgitb.enable()

param = get_param()
workdir = param[0]
in_dir = os.path.join(workdir, 'jobs')
tmp_dir = os.path.join(workdir, 'tmp')
gb_dir = os.path.join(tmp_dir, 'gbk')
tag_dir = os.path.join(workdir, 'Tag')

form = cgi.FieldStorage()

def get_run_id():
    return form.getvalue('entry')

def get_input_type():
    return form.getvalue('optionsRadios')

def get_input_file():
    return form['inputFile']

def redirect_to_error(error_code):
    url = f"https://tool-mml.sjtu.edu.cn/NSPOMdb/Error.php?check={error_code}"
    print("Content-type: text/html")
    print(f"Location: {url}")
    print()
    sys.exit()

def redirect_to_job(run_id):
    url = f"https://tool-mml.sjtu.edu.cn/NSPOMdb/jobstat.php?job={run_id}"
    print("Content-type: text/html")
    print(f"Location: {url}")
    print()
    sys.exit()

def validate_input():
    input_type = get_input_type()
    file_item = get_input_file()
    if not input_type:
        redirect_to_error("notype")
    if not file_item.filename:
        redirect_to_error("nofile")
    return file_item

def detect_file_type(file_path):
    file_type = None
    with open(file_path, "r") as handle:
        if any(SeqIO.parse(handle, "fasta")):
            file_type = "fa"
    with open(file_path, "r") as handle:
        if any(SeqIO.parse(handle, "gb")):
            file_type = "gb"
    return file_type

def process_file(run_id):
    file_item = validate_input()
    input_file_dir = os.path.join(in_dir, run_id)
    os.makedirs(input_file_dir, mode=0o777, exist_ok=True)
    input_file_path = os.path.join(input_file_dir, run_id)
    with open(input_file_path, 'wb') as f:
        f.write(file_item.file.read())
    file_type = detect_file_type(input_file_path)
    if not file_type:
        redirect_to_error("wrongf")
    if file_type == "fa":
        fasta_file = os.path.join(input_file_dir, f"{run_id}.fa")
        seq_records = list(SeqIO.parse(input_file_path, "fasta"))
        if len(seq_records) == 1:
            SeqIO.write(seq_records[0], fasta_file, "fasta")
        else:
            shutil.move(input_file_path, fasta_file)
    elif file_type == "gb":
        if not os.path.exists(gb_dir):
            os.makedirs(gb_dir, mode=0o777)
        gbk_file = os.path.join(gb_dir, f"{run_id}.gbk")
        fasta_file = os.path.join(input_file_dir, f"{run_id}.fa")
        seq_records = list(SeqIO.parse(input_file_path, "gb"))
        if len(seq_records) == 1:
            SeqIO.write(seq_records[0], gbk_file, "gb")
            SeqIO.write(seq_records[0], fasta_file, "fasta")
        else:
            redirect_to_error("gbf")
    return fasta_file, file_type

# def create_tag(input_type, run_id):
#     tag_dict = {'Chromosome': 'c_', 'Plasmid': 'p_', 'Contig': 'co_', 'Meta': 'm_'}
#     tag_file = os.path.join(tag_dir, f"{tag_dict[input_type]}{run_id}")
#     if not os.path.exists(tag_file):
#         open(tag_file, "w").close()

def create_start_flag(run_id):
    start_file = os.path.join(tag_dir, f"s_{run_id}")
    if not os.path.exists(start_file):
        open(start_file, "w").close()

def execute_analysis(input_file, input_type, run_id):
    log_file = os.path.join(in_dir, run_id, "error.log")
    cmd = [
        '/public/shenyx/software/miniconda3/envs/VRprofile2/bin/python',
        '/var/www/cgi-bin/OBMicro/ARG-VFG-finder/ARG-VFG-finder.py',
        '-i', input_file, '-t', input_type, '-o', run_id
    ]
    with open(log_file, "a") as f:
        subprocess.Popen(cmd, stdout=f, stderr=f)

if __name__ == "__main__":
    try:
        run_id = get_run_id()
        input_type = get_input_type()
        input_file, file_type = process_file(run_id)

        if input_type in ["Plasmid", "Chromosome"]:
            create_start_flag(run_id)
            execute_analysis(input_file, input_type, run_id)
            # create_tag(input_type, run_id)
            redirect_to_job(run_id)
        elif input_type in ["Contig", "Meta"]:
            if file_type == "gb":
                redirect_to_error("contiggb")
            create_start_flag(run_id)
            execute_analysis(input_file, input_type, run_id)
            # create_tag(input_type, run_id)
            redirect_to_job(run_id)
        else:
            redirect_to_error("invalid_input")
    except Exception as e:
        redirect_to_error("server")