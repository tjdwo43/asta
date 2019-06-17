#!/usr/bin/expect -f
set timeout 100
set pass [lindex $argv 0]
spawn sudo  smbpasswd  -a  $pass 
sleep 1
expect "New SMB password:"
send "$pass\r\n"
expect "Retype new SMB password:"
send "$pass\r\n"



interact
