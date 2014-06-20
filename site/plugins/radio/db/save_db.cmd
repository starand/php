@echo off
d:
cd d:\home\bkp\backups\mysql\
"c:\pfiles\AppServ\MySQL\bin\mysqldump.exe" --u stream --password --databases radio > radio.sql
