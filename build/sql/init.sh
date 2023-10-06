#!/bin/bash
HOSTNAME="localhost"
PORT="3306"
USERNAME="root"
PASSWORD="root"
WEB="WEB"

mysql -h$HOSTNAME -P$PORT -u$USERNAME -p$PASSWORD -e "create database $WEB DEFAULT CHARACTER SET utf8;"
mysql -u$USERNAME -p$PASSWORD $WEB < web.sql
