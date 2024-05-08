#!/bin/bash

serverA_ip="192.168.100.4"
serverB_ip="192.168.100.4" # using same server, but different port for php app
browser_ip="192.168.100.5"
proxy_ip="192.168.100.8"

sysctl -w net.ipv4.ip_forward=1

iptables -t nat -A PREROUTING -s $browser_ip -d $proxy_ip -p tcp --dport 8080 -j DNAT --to-destination $serverA_ip:8080
iptables -t nat -A POSTROUTING -s $browser_ip -d $serverA_ip -p tcp --dport 8080 -j SNAT --to-source $proxy_ip

# added for task2
iptables -t nat -A PREROUTING -s $browser_ip -d $proxy_ip -p tcp --dport 8081 -j DNAT --to-destination $serverB_ip:8081
iptables -t nat -A POSTROUTING -s $browser_ip -d $serverB_ip -p tcp --dport 8081 -j SNAT --to-source $proxy_ip

iptables -t nat -A PREROUTING -s $serverA_ip -d $proxy_ip -p tcp --dport 8080 -j DNAT --to-destination $browser_ip:80
iptables -t nat -A POSTROUTING -s $serverA_ip -d $browser_ip -p tcp --dport 80 -j SNAT --to-source $proxy_ip

# added for task2
iptables -t nat -A PREROUTING -s $serverB_ip -d $proxy_ip -p tcp --dport 8081 -j DNAT --to-destination $browser_ip:80
iptables -t nat -A POSTROUTING -s $serverB_ip -d $browser_ip -p tcp --dport 80 -j SNAT --to-source $proxy_ip
