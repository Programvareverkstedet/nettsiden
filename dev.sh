#!/bin/sh
which -s sqlite3 && test \! -e pvv.sqlite && sqlite3 pvv.sqlite < pvv.sql
php -S [::]:1080 -t www/
