#!/public/shenyx/software/miniconda3/bin/python
# -*- coding: utf-8 -*-

import os,time
import random,json
import string,shutil
from sys import argv
from Bio import SeqIO

from package.utils import *
from package.argfinder import arg_predict_contigs
from package.vfinder import vf_predict_contigs
from script.chr_contig import _chr

param = get_param()
workdir = param[0]
soft_dir = param[1]
kraken = param[3]
krakenDB = param[4]

def identifypc(runID,infa):
	final_dir = os.path.join(workdir,'jobs',runID)
	outdir = os.path.join(final_dir,runID+'_viral')
	if os.path.exists(outdir):
		shutil.rmtree(outdir)
	viralcmd = 'software/viralVerify/bin/viralverify -f ' + infa + ' -o ' + outdir +' --hmm data/Pfam-A.hmm -t 8 > /dev/null'
	os.system(viralcmd)
	
	virald_o = {}
#	virald_r = {}
	if os.path.exists(os.path.join(outdir,runID+'_unk-results.csv')):
		viralfile = open(os.path.join(outdir,runID+'_unk-results.csv'),'r')
		for line in viralfile.readlines():
			lines = line.strip().split(',')
			if lines[0] != 'contig_name':
				judge_for_out = lines[1].split(' ')[0]
#				if lines[1] == 'Chromosome':
#					judge_for_run = 'Chromosome'
#				else:
#					judge_for_run = 'Plasmid'
				virald_o[lines[0]] = judge_for_out
#				virald_r[lines[0]] = judge_for_run

	return virald_o #,virald_r

def getfasta(runID, infile):
	final_dir = os.path.join(workdir,'jobs',runID)

	i = 0
	id_dict = {}
	locdict = {}
	unk = os.path.join(final_dir,runID+'_unk.fa')
	newf = os.path.join(final_dir,runID+'_rename.fa')
	unkfa = open(unk,'w')
	newfa = open(newf,'w')
	lenlist = []

	for seq_record in SeqIO.parse(infile, "fasta"):
		realID = seq_record.id
		contigID = 'contig_' + str(i)
		seq_record.id = contigID

		seqlen = len(seq_record)
		seqfa = str(seq_record.seq)
		lenlist.append(seqlen)

		if seqlen < 2000:
			continue
		elif seqlen > 1000000:
			locdict[contigID] = 'Chromosome'
		else:
			unkfa.write(">%s\n%s\n" % (contigID,seqfa))
		id_dict[contigID] = realID
		i += 1
		newfa.write(">%s\n%s\n" % (contigID,seqfa))

	virald_o = identifypc(runID,unk)

	return id_dict, dict(virald_o,**locdict)

def _meta(runID,infile):
	tag_dir = os.path.join(workdir,'Tag')
	final_dir = os.path.join(workdir,'jobs',runID)

	id_dict,viraldict = getfasta(runID,infile)

	rename_fa = os.path.join(final_dir,runID+'_rename.fa')
	prokka_cmd = (
		f"/public/shenyx/software/miniconda3/envs/VRprofile2/bin/prokka {rename_fa} "
		f"--force --quiet --cpus 48 --outdir {final_dir} --prefix {runID} --metagenome"
	)
	env = os.environ.copy()
	env["PATH"] = "/public/shenyx/software/miniconda3/envs/VRprofile2/bin:" + env["PATH"]
	result = subprocess.run(prokka_cmd, shell=True, env=env)
	if result.returncode != 0:
		logging.error("Prokka execution failed!")
		sys.exit(1)

	arg_list = arg_predict_contigs(rename_fa, runID)

	arg_json_data = []	
	with open (os.path.join(final_dir, 'Antibiotic_Resistance_Gene.txt'), 'w') as arg_output:
		arg_header = 'ARG\tContig\tReplicon\tCoord\tStrand\tDrugClass\tDrugs'
		arg_output.write(arg_header + '\n')
		for c, s, e, strand, d in arg_list:
			contig = id_dict[c]
			replicon = viraldict.get(c, 'Uncertain')
			argname, drugc = d.split('\t')
			drugcc, drug = drugc.split('@')
			drug = drug.replace('~ARG', '')
			coord = f"{s}..{e}"
			arg_output.write('\t'.join([argname, contig, replicon, coord, strand, drugcc, drug]) + '\n')

			# Append to JSON data
			arg_json_data.append({
				"ARG": argname,
				"Contig": contig,
				"Replicon": replicon,
				"Coord": coord,
				"Strand": strand,
				"DrugClass": drugcc,
				"Drugs": drug
			})

	argout = os.path.join(final_dir,'Antibiotic_Resistance_Gene.json')
	jsObj = json.dumps(arg_json_data)
	with open(argout,'w') as output:
		output.write(jsObj)

	vf_list = vf_predict_contigs(rename_fa, runID)
	vf_json_data = []
	with open(os.path.join(final_dir, 'Virulence_Factor.txt'), 'w') as vf_output:
		vf_header = 'VF\tContig\tReplicon\tCoord\tStrand\tDescription\tEvalue'
		vf_output.write(vf_header + '\n')
		for vf in vf_list:
			contig = id_dict[vf[0]]
			replicon = viraldict.get(vf[0], 'Uncertain')
			coord = f"{vf[1]}..{vf[2]}"
			description = vf[5].rsplit(' [', 1)[0]
			vf_output.write('\t'.join([vf[4], contig, replicon, coord, vf[3], description, vf[6]]) + '\n')

			# Append to JSON data
			vf_json_data.append({
				"VF": vf[4],
				"Contig": contig,
				"Replicon": replicon,
				"Coord": coord,
				"Strand": vf[3],
				"Description": description,
				"Evalue": vf[6]
			})
	vfout = os.path.join(final_dir,'Virulence_Factor.json')
	jsObj = json.dumps(vf_json_data)
	with open(vfout,'w') as vf_output:
		vf_output.write(jsObj)

	tag_file = os.path.join(tag_dir, f"m_{runID}")
	if not os.path.exists(tag_file):
		open(tag_file, "w").close()

if __name__ == '__main__':
	infile = argv[1]
#	runID = randomID(10)
	runID = "Example_Meta"
	_meta(runID,infile)

