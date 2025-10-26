#!/public/shenyx/software/miniconda3/envs/VRprofile2/bin/python
# -*- coding: utf-8 -*-

import os, re, sys
from sys import argv

workdir = "/var/www/cgi-bin/OBMicro/ARG-VFG-finder"
Tag_dir = os.path.join(workdir,'Tag')

def get_result(runID):
	tag_files = os.listdir(Tag_dir)
	tag_dict = {}
	for line in tag_files:
		if '_' in line:
			intype,ID = line.strip().split('_', 1)
			tag_dict[ID]=intype

	if runID in tag_dict:
		checkt = tag_dict[runID]
		if checkt == 'p' or checkt == 'c':
			_res = tag_dict[runID]
		elif checkt == 'co':
			_res = 'Contig'
		elif checkt == 'm':
			_res = 'Meta'
		elif checkt == 'f':
			_res = 'Fungi'
		elif checkt == 'e':
			_res = 'Error'
		else:
			_res = 'start'
	else:
		_res = 'none'

	return _res

if __name__ == '__main__':

	runID = argv[1]
	print(get_result(runID))
