
#!/bin/bash
isExistApp=pgrep httpd
if [[ -n $isExistApp ]]; then
systemctl stop httpd
fi
isExistApp=pgrep mysqld
if [[ -n $isExistApp ]]; then
systemctl stop mysql
fi
isExistApp=pgrep php-fpm
if [[ -n $isExistApp ]]; then
systemctl stop php-fpm

fi
