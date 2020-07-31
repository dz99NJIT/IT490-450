#!/bin/sh
sudo mkdir Backup-$(date +"%d-%m-%Y")
sudo cp -r IT490-450/  Backup-$(date +"%d-%m-%Y")
sudo scp -i Key1.pem -r IT490-450/ ubuntu@54.211.234.33:~
