#!/bin/sh
sudo mkdir Backup-$(date +"%d-%m-%Y")
sudo cp -r IT490-450/  Backup-$(date +"%d-%m-%Y")
sudo scp -i Key1.pem -r DEV_QA_API.sh ubuntu@54.197.169.78:~
