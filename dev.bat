IF EXIST "sql_config.php" goto config_end
cp sql_config_example.php sql_config.php 
:config_end

IF EXIST "pvv.sqlite" goto sqlite_end
sqlite3 pvv.sqlite < pvv.sql
:sqlite_end

php -S [::]:1080 -t www/ -c php.ini