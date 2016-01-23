#!/bin/bash

#设置ip
ifconfig

#设置路由
route

#域名解析
host/nslookup 

#网络连通主机存活 fping需下载软件包
ping/fping 

#网络情况
traceroute

#文件的下载上传
ftp/sftp/rsync/scp

#远程登录
ssh
echo in-data | ssh user@remote-host command > out-data 这个command是远程机器上执行的命令 in-data是送入远程机器上的数据

#网络文件系统
nfs/sshfs

#查看打开文件句柄情况
lsof -i

#查看网络端口使用情况
netstat  -a 所有的 -t tcp -u udp -n 按ip显示 #-p tcp mac os


