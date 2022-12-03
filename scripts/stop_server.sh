
#!/bin/bash
sudo chmod +x scripts/stop_server.sh
isExistApp=`pgrep httpd`
if [[ -n $isExistApp ]]; then
systemctl stop httpd
fi
isExistApp=`pgrep mysqld`
if [[ -n $isExistApp ]]; then
systemctl stop mysql
fi
isExistApp=`pgrep php-fpm`
if [[ -n $isExistApp ]]; then
systemctl stop php-fpm

fi
