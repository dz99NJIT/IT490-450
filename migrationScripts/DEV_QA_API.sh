#!/bin/sh
sudo mkdir Backup-$(date +"%d-%m-%Y")
sudo cp -r IT490-450/  Backup-$(date +"%d-%m-%Y")
sudo scp -i Key2.pem -r IT490-450/ ubuntu@52.72.3.66:~
