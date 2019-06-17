#!/usr/bin/expect -f
set timeout 100

spawn sudo smbpasswd [lindex $argv 0]
sleep 1
expect "New SMB password:"
send "[lindex $argv 1]\r\n"
expect "Retype new SMB password:"
send "[lindex $argv 1]\r\n"

interact
 
