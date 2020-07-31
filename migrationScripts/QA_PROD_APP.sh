#!/bin/sh
#sudo mkdir Backup-$(date +"%d-%m-%Y")
#sudo cp -r IT490-450/  Backup-$(date +"%d-%m-%Y")
sudo scp -i Key3.pem -r DEV_QA_API.sh ubuntu@3.210.133.174:~
