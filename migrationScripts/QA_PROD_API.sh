#!/bin/sh
sudo mkdir Backup-$(date +"%d-%m-%Y")
sudo cp -r IT490-450/  Backup-$(date +"%d-%m-%Y")
sudo scp -i Key1.pem -r IT490-450/ ubuntu@52.45.99.89:~
