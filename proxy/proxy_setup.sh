#!/bin/bash

# tutorial: https://www.karlrupp.net/en/computer/nat_tutorial

server_ip="192.168.100.4"
browser_ip="192.168.100.5"
proxy_ip="192.168.100.8"

sysctl -w net.ipv4.ip_forward=1 # allow forwarding

# for TCP packets from browser_ip to proxy_ip:8080, change destination to server_ip:8080
iptables -t nat -A PREROUTING -s $browser_ip -d $proxy_ip -p tcp --dport 8080 -j DNAT --to-destination $server_ip:8080
# for TCP packets from browser_ip to server_ip:8080 (done by prerouting rule!), change source to proxy_ip
iptables -t nat -A POSTROUTING -s $browser_ip -d $server_ip -p tcp --dport 8080 -j SNAT --to-source $proxy_ip

iptables -t nat -A PREROUTING -s $server_ip -d $proxy_ip -p tcp --dport 8080 -j DNAT --to-destination $browser_ip:80
iptables -t nat -A POSTROUTING -s $server_ip -d $browser_ip -p tcp --dport 80 -j SNAT --to-source $proxy_ip

# to check rules: iptables --table nat --list

# for traffic capture: tcpdump -i <interface> 'host <server-ip> or <browser-ip>'
# e.g. tcpdump -i enp0s3 'host 192.168.100.4 or 192.168.100.5' -w <output-file>

# use filters as `tcp contains "cs745 attack"` in wireshark
