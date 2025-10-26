#!/public/shenyx/software/miniconda3/bin/python
# -*- coding: utf-8 -*-

import os
import json,shutil
from Bio import SeqIO
from package.utils import *
from package.argfinder import arg_predict
from package.vfinder import vf_predict

def _chr(runID,infile,filetype):
	# Step 1: Get genome information
	param = get_param()
	workdir = param[0]
	tag_dir = os.path.join(workdir, 'Tag')
	final_dir = os.path.join(workdir,'jobs', runID)
	realID, lengt, GCi = genomeinfo(runID, infile, filetype)
	infile = os.path.join(final_dir, f"{runID}.fna")

	# Define output files
	all_arg = os.path.join(final_dir, 'Antibiotic_Resistance_Gene.txt')
	all_arg_json = os.path.join(final_dir, 'Antibiotic_Resistance_Gene.json')
	all_vf = os.path.join(final_dir, 'Virulence_Factor.txt')
	all_vf_json = os.path.join(final_dir, 'Virulence_Factor.json')


	# Step 2: Predict ARGs and VFs
	AR_list = arg_predict(infile, runID) 
	vf_list = vf_predict(runID) 

	# Step 3: Generate ARG prediction result file (TXT and JSON)
	arg_json_data = []
	with open(all_arg, 'w') as arg_output:
		arg_header = 'ARG\tCoord\tStrand\tDrugClass\tDrugs'
		arg_output.write(arg_header + '\n')
		for s, e, strand, d in AR_list:
			argname, drugc = d.split('\t')
			drugcc, drug = drugc.split('@')
			drug = drug.replace('~ARG', '')
			coord = f"{s}..{e}"
			arg_output.write('\t'.join([argname, coord, strand, drugcc, drug]) + '\n')

			# Append to JSON data
			arg_json_data.append({
				"ARG": argname,
				"Coord": coord,
				"Strand": strand,
				"DrugClass": drugcc,
				"Drugs": drug
			})

	# Write ARG JSON data
	with open(all_arg_json, 'w') as arg_json_output:
		json.dump(arg_json_data, arg_json_output, indent=4)

	# Step 4: Generate VF prediction result file (TXT and JSON)
	vf_json_data = []
	with open(all_vf, 'w') as vf_output:
		vf_header = 'VF\tCoord\tStrand\tDescription\tEvalue'
		vf_output.write(vf_header + '\n')
		for vf, s, e, strand, des, evalue in vf_list:
			coord = f"{s}..{e}"
			description = des.rsplit(' [', 1)[0]
			vf_output.write('\t'.join([vf, coord, strand, description, evalue]) + '\n')

			# Append to JSON data
			vf_json_data.append({
				"VF": vf,
				"Coord": coord,
				"Strand": strand,
				"Description": description,
				"Evalue": evalue
			})

	# Write VF JSON data
	with open(all_vf_json, 'w') as vf_json_output:
		json.dump(vf_json_data, vf_json_output, indent=4)

	# Step 5: Summary and final output, create complete tag
	print(f"ARG and VF prediction for {realID} completed.")
	tag_file = os.path.join(tag_dir, f"c_{runID}")
	if not os.path.exists(tag_file):
		open(tag_file, "w").close()


if __name__ == '__main__':
	realID = 'CP015001.1'
	runID = 'ieb4DQx0Psxb5hb'
        
	_chr(realID,runID)