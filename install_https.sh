openssl genrsa -des3 -out server.key 1024
openssl req -new -key server.key -out server.csr
cp server.key server.key.org
openssl rsa -in server.key.org -out server.key
openssl x509 -req -days 365 -in server.csr -signkey server.key -out server.crt
sudo cp server.crt /etc/ssl/certs/server.crt
sudo cp server.key /etc/ssl/private/server.key
sudo cp secure-bank.conf /etc/apache2/sites-available/secure-bank.conf
sudo a2ensite secure-bank.conf
sudo service apache2 force-reload