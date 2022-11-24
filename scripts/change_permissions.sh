#!/bin/bash
cd /var/www/html/sample-preceptor
yum install wget -y
wget https://getcomposer.org/composer.phar
php composer.phar install
