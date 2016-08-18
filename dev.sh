#!/bin/sh
which -s sqlite3 && test \! -e pvv.sqlite && sqlite3 pvv.sqlite < pvv.sql
test \! -e sql_config.php && cp sql_config_example.php sql_config.php
php -S [::]:1080 -t www/
