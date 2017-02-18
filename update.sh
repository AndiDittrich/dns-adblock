#!/bin/bash

HOST_FILE="https://raw.githubusercontent.com/StevenBlack/hosts/master/alternates/fakenews/hosts"

# fetch file
wget $HOST_FILE -O hosts.txt

# run converter
php convert.php