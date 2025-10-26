# NSPOMdb

Simple README for the NSPOMdb web project (OBMicro).

## What this repo contains
- Web application files and data used by the OBMicro project.

## Notes
- A large file (`assets/VF_info.csv`) was removed from the repository history to meet GitHub limits.
- A backup branch named `backup-before-remove` still exists locally containing the original history (do not delete it if you need to recover the original file).

## Run / Development
- This is a PHP web project; run with a local web server (e.g., place in your Apache/nginx document root or run PHP built-in server):

  ```powershell
  # from repository root
  php -S localhost:8000
  ```

## Large files
- If you need to keep large data files in the future, consider using Git LFS (`git lfs install` and `git lfs track`) or host large datasets externally.

## Contact
- For questions about this repository, contact the maintainer.
