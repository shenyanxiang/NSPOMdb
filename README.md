# NSPOMdb Source Code

This repository contains the original source code and computational workflows used to build the Non-sterile Product Objectionable Microorganism Database (NSPOMdb) — an integrated web resource for the curation, analysis, and risk assessment of microbial contamination events in non-sterile products.

## Repository Structure
### ARG-VFG-finder/

This directory contains the complete source code of the ARG-VFG-finder tool, which automatically annotates antimicrobial resistance genes (ARGs) and virulence factor genes (VFGs) from microbial genomic or protein sequences.
It includes all scripts used for model execution, parameter setting, and performance validation as described in the manuscript.

### scripts/finished_product_DT.php & raw_materials_DT.php

 – Implements the decision-tree algorithm for qualitative risk assessment of finished non-sterile products and raw materials.

### simulation.php 

– Implements the quantitative microbial risk calculation model, which computes a real-time risk score based on product and microbial parameters.