#!/usr/bin/expect -f
set timeout 100

spawn sudo passwd [lindex $argv 0]
sleep 1
expect "Enter new UNIX password:"
send "[lindex $argv 1]\r\n"
expect "Retype new UNIX password:"
send "[lindex $argv 1]\r\n"

interact
 
