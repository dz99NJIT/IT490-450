  
#!/bin/sh
sudo mkdir Backup-$(date +"%d-%m-%Y")
sudo cp -r IT490-450/  Backup-$(date +"%d-%m-%Y")
sudo scp -i Key3.pem -r IT490-450/ ubuntu@54.145.41.212:~
