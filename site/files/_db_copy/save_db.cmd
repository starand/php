@echo off
d:
cd d:\home\.bkp\.sql\
"c:\pfiles\AppServ\MySQL\bin\mysqldump.exe" --u stream --password --databases KnowBase > KnowBase.sql
"c:\pfiles\AppServ\MySQL\bin\mysqldump.exe" --u stream --password --databases hack > hack.sql
"c:\pfiles\AppServ\MySQL\bin\mysqldump.exe" --u stream --password --databases radio > radio.sql
"c:\pfiles\AppServ\MySQL\bin\mysqldump.exe" --u stream --password --databases smartHouse > smartHouse.sql