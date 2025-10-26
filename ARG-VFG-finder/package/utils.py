#!/public/software/shenyx/miniconda3/bin/python
# -*- coding: utf-8 -*-

import os
import sys
import time
import shutil
import configparser
from Bio import SeqIO
from Bio.SeqUtils import GC
from typing import Tuple
import logging
import subprocess

# Initialize logging
logging.basicConfig(level=logging.INFO, format='%(asctime)s - %(levelname)s - %(message)s')

def get_param():
    conf = configparser.ConfigParser()
    conf.read("./config.ini")
    options = conf.options("Param")
    workdir = conf.get("Param", "workdir")
    soft_dir = conf.get("Param", "softdir")
    dbscan = conf.get("Param", "dbscan")
    kraken = conf.get("Param", "kraken")
    krakenDB = conf.get("Param", "krakenDB")
    rep_ident = conf.get("Param", "rep_ident")
    rep_cov = conf.get("Param", "rep_cov")
    return workdir,soft_dir,dbscan,kraken,krakenDB,rep_ident,rep_cov

# Load parameters
param = get_param()
workdir = param[0]
soft_dir = param[1]

final_dir = os.path.join(workdir, 'jobs')
tag_dir = os.path.join(workdir, 'Tag')

def get_time() -> str:
    """Get the current time as a formatted string."""
    return time.asctime(time.localtime(time.time()))

def ensure_dir_exists(directory: str):
    """Ensure a directory exists, creating it if necessary."""
    os.makedirs(directory, exist_ok=True)
    os.chmod(directory, 0o777)

def fa2gb(runID: str, infile: str) -> str:
    """
    Convert a FASTA file to a GenBank file using Prokka.
    Returns the real ID of the genome.
    """
    size = len(list(SeqIO.parse(infile, "fasta")))
    if size == 1:
        seq_record = next(SeqIO.parse(infile, "fasta"))
        try:
            realID = seq_record.description.split(' ')[1][:20]
        except IndexError:
            realID = seq_record.id
        prokka_cmd = (
            f"/public/shenyx/software/miniconda3/envs/VRprofile2/bin/prokka {infile} "
            f"--force --quiet --cpus 48 --outdir {os.path.join(final_dir, runID)} --prefix {runID}"
        )
        env = os.environ.copy()
        env["PATH"] = "/public/shenyx/software/miniconda3/envs/VRprofile2/bin:" + env["PATH"]
        result = subprocess.run(prokka_cmd, shell=True, env=env)
        if result.returncode != 0:
            logging.error("Prokka execution failed!")
            sys.exit(1)
    elif size > 1:
        logging.error("Only single sequence is accepted. Please check your input!")
        tag_file = os.path.join(tag_dir, f"e_{runID}")
        if not os.path.exists(tag_file):
            open(tag_file, "w").close()
        sys.exit(1)
    else:
        logging.error("The uploaded file is not in a standard format! Please check!")
        tag_file = os.path.join(tag_dir, f"e_{runID}")
        if not os.path.exists(tag_file):
            open(tag_file, "w").close()
        sys.exit(1)
    return realID

def gb2faa(runID: str, infile: str, gbfile: str) -> str:
    """
    Extract protein sequences from a GenBank file and save them as a FASTA file.
    Returns the real ID of the genome.
    """
    faafile = os.path.join(os.path.join(final_dir, runID), f"{runID}.faa")
    with open(faafile, "w") as output_handle:
        realID = None
        idlist = []
        for seq_record in SeqIO.parse(gbfile, "gb"):
            realID = seq_record.name[:20]
            for seq_feature in seq_record.features:
                if seq_feature.type == "CDS":
                    id = seq_feature.qualifiers.get('locus_tag', [None])[0] or \
                         seq_feature.qualifiers.get('gene', [None])[0]
                    if not id or 'translation' not in seq_feature.qualifiers:
                        continue
                    output_handle.write(f">{id}\n{seq_feature.qualifiers['translation'][0]}\n")
                    idlist.append(id)
        if not idlist:
            realID = fa2gb(runID, infile)
    return realID

def genomeinfo(runID: str, infile: str, filetype: str) -> Tuple[str, str, str]:
    """
    Generate genome information files and return genome ID, length, and GC content.
    """
    ensure_dir_exists(final_dir)
    ensure_dir_exists(os.path.join(final_dir, runID))

    if filetype == 'fa':
        realID = fa2gb(runID, infile)
    else:
        gbfile = os.path.join(os.path.join(final_dir, runID), f"{runID}.gbk")
        realID = gb2faa(runID, infile, gbfile)
        shutil.copy(infile, os.path.join(os.path.join(final_dir, runID), f"{runID}.fna"))

    infom = os.path.join(os.path.join(final_dir, runID), f"{runID}.genome_local1")
    infom1 = os.path.join(os.path.join(final_dir, runID), f"{runID}.genome_web1")
    genome_base = (
        "'use strict';\nvar app = angular.module('vixis', "
        "['ngSanitize', 'vr.directives.slider', 'ui.bootstrap','angularplasmid']);"
        "\napp.controller('PlasmidCtrl', ['$http', '$scope', '$timeout', "
        "function ($http, $scope, $timeout) {"
        "\n$scope.markerClick = function(event, marker){$scope.$apply(function()"
        "{$scope.selectedmarker = marker;});}"
        "\n$scope.dismissPopup = function(){$scope.selectedmarker = null;}\n"
    )

    seq_record = next(SeqIO.parse(infile, 'fasta'))
    lengt = len(seq_record.seq)
    gcs = f"{GC(seq_record.seq):.2f}"
    counts = int(pow(10, len(str(lengt)) - 1))
    maxc = int(lengt / counts)
    tick1 = counts * maxc / 5
    tick2 = int(tick1 / 2)

    with open(infom, 'w') as gein:
        gein.write(f"GenomeID : {realID}\n")
        gein.write(f"GenomeSize : {lengt}\n")
        gein.write(f"GenomeGC : {gcs}\n")

    with open(infom1, 'w') as gein1:
        gein1.write(genome_base)
        gein1.write(f"\t$scope.time = '{get_time()}';\n")
        gein1.write(f"\t$scope.name = '{realID}';\n")
        gein1.write(f"\t$scope.length = {lengt};\n")
        gein1.write(f"\t$scope.tick1 = {tick1};\n")
        gein1.write(f"\t$scope.tick2 = {tick2};\n")

    return realID, str(lengt), gcs

if __name__ == '__main__':
    logging.info("Script executed as the main program. Please call the necessary functions.")