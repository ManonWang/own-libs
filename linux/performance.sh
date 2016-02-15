#!/bin/bash

#文件大小
du -sh 

#磁盘空间
df -sh

#计算程序执行时间
time

#系统在线用户
w/who/id/users

#最后一次登录时间
last

#系统启动时间
uptime

#获取进程信息(进程所占用内存和cpu等信息)
ps 

#本机名(ip)
hostname 
hostname -i 

#操作系统内核信息
uname -a

#操作系统发行版
cat /etc/issue 

#操作系统发行信息
lsb_release -a

#cpu信息
lscpu
cat /proc/cpuinfo
getconf LONG_BIT #当前cpu运行是64位还是32位

#内存信息
cat /proc/meminfo

#网卡信息
dmesg | grep -i eth

#硬盘信息
df -lh

#主机型号
dmidecode | grep "Product Name"

#分析CPU瓶颈
方法一：
uptime/w/top 
load average为1分钟、5分钟、15分钟的负载，越大压力越大。 服务器合理负载是CPU核数。也就是说对于8核的CPU，负载在8以内表明负载低。如果负载超过8了，就说明服务器的运行有一定的压力了。

方法二:
vmstat 2 3
user% + sys%< 70%（好）   user% + sys%= 85% （一般）   user% + sys% >=90% (很差)

方法三：
top
user% + sys%< 70%（好）   user% + sys%= 85% （一般）   user% + sys% >=90% (很差)

方法四：
sar -u 3 5
user% + sys%< 70%（好）   user% + sys%= 85% （一般）   user% + sys% >=90% (很差) 

如何找出最耗cpu的程序
按top 然后 shift + p


#分析内存瓶颈
方法一:
free -m
应用程序可用内存=free+buffers+cached
系统物理内存=total
应用程序可用内存/系统物理内存>70%时，表示系统内存资源非常充足，不影响系统性能，
20%<应用程序可用内存/系统物理内存<70%时，表示系统内存资源基本能满足应用需求，暂时不影响系统性能。
应用程序可用内存/系统物理内存<20%时，表示系统内存资源紧缺，需要增加系统内存，

方法二：
vmstat 2 3
swap的si和swap的so 长期大于0

方法三：
top
swap中的used约接近total,就越缺少内存
Swap:  4063224k total,   361436k used,  3701788k free,  1388532k cached

如何找出最耗内存的程序
按top 然后 shift + m

#分析IO瓶颈
方法一：
top
iowait % < 20% （好）  iowait % =35% （一般）   iowait % >= 50% （很差）

方法二：
iostat -x 1 10
await 大于10ms,IO压力大
util 越接近100% IO压力大

如何找出最耗IO的程序
iotop

#分析网络IO瓶颈
方法一：
netstat -i
RX-OK / TX-OK ： 准确无误地接收 / 发送了多少数据包
RX-ERR / TX-ERR ： 接收 / 发送数据包时产生了多少错误
RX-DRP / TX-DRP ： 接收 / 发送数据包时丢弃了多少数据包
RX-OVR / TX-OVR ： 由于误差而遗失了多少数据包
正常情况下RX-ERR，RX-DRP，RX-OVR，TX-ERR，TX-DRP，TX-OVR都应该为0， 这些值越大，网络越有问题

方法二：
sar -n DEV 2 3
FACE：网络接口设备
rxpck/s：每秒接收的数据包大小
txpck/s：每秒发送的数据包大小
rxkB/s：每秒接受的字节数
txkB/s：每秒发送的字节数
rxcmp/s：每秒接受的压缩数据包
txcmp/s：每秒发送的压缩数据包
rxmcst/s：每秒接受的多播数据包
rxkB/s txkB/s 越接近最大值，带宽越不足

其它扩展
查看网卡带宽:ethtool eth0
最大传输速度=带宽/8  100M带宽最大12M/s 100M带宽最大128M/s
tcp当前并发连接: netstat -nat | grep ESTABLISHED | wc -l

netstat -n | awk '/^tcp/ {++S[$NF]} END {for(a in S) print a, S[a]}' #tcp连接状态统计
CLOSED：无连接是活动的或正在进行 
LISTEN：服务器在等待进入呼叫 
SYN_RECV：一个连接请求已经到达，等待确认 
SYN_SENT：应用已经开始，打开一个连接 
ESTABLISHED：正常数据传输状态 
FIN_WAIT1：应用说它已经完成 
FIN_WAIT2：另一边已同意释放 
ITMED_WAIT：等待所有分组死掉 
CLOSING：两边同时尝试关闭 
TIME_WAIT：另一边已初始化一个释放 
LAST_ACK：等待所有分组死掉


#iostat用法
用法：
iostat -x 1 10 -x表示显示所有参数信息，1表示每隔1秒监控一次，10表示共监控10次
结果：
Linux 2.6.32-431.el6.x86_64 (wangge.dev.firstp2p.net)   2016年01月26日  _x86_64_        (8 CPU)
avg-cpu:  %user   %nice %system %iowait  %steal   %idle
           0.47    0.00    0.39    0.04    0.00   99.10
Device:         rrqm/s   wrqm/s     r/s     w/s   rsec/s   wsec/s avgrq-sz avgqu-sz   await  svctm  %util
sda               0.03    15.14    0.10   27.25     4.65   341.02    12.64     0.01    0.31   0.21   0.58
dm-0              0.00     0.00    0.12   42.32     4.52   340.41     8.13     0.03    0.75   0.14   0.58
解析：
Device：设备或分区名称。
Tps：设备每秒的传输次数。一个IO请求表示一个传输。多个逻辑请求可以被组成一个I/O请求。一个传输的大小未知。
Blk_read/s：每秒从设备读取数据量
Blk_wrtn/s：每秒写入设备的数据量
Blk_read：读取的总数量
Blk_wrtn：写入的总数量
kB_read/s：每秒从设备读取的数据量（单位：KB）
kB_wrtn/s：每秒写入设备的数据量（单位：KB）
kB_read ：读取的总数量（单位：KB）
kB_wrtn：写入的总数量（单位：KB）
MB_read/s：每秒从设备读取的数据量（单位：MB）
MB_wrtn/s：每秒写入设备的数据量（单位：MB）
MB_read：读取的总数量（单位：MB）
MB_wrtn：写入的总数量（单位：MB）
rrqm/s：每秒被合并的读请求数
wrqm/s：每秒被合并的写请求数
r/s ：每秒的读请求数
w/s ：每秒的写请求数
rsec/s：每秒读取的扇区数
wsec/s：每秒写入的扇区数
rkB/s：每秒从设备读取的数据量（单位：KB）
wkB/s：每秒写入设备的数据量（单位：KB）
rMB/s：每秒从设备读取的数据量（单位：MB）
wMB/s：每秒写入设备的数据量（单位：MB）
avgrq-sz    ：平均每次IO操作的数据量(扇区数为单位)
avgqu-sz：平均等待处理的IO请求队列长度 
await：I/O请求等待时间的平均值（单位：毫秒),   一般低于5ms，大于10ms IO压力大
svctm：I/O请求处理时间的平均值（单位：毫秒）
%util：消耗在I/O请求中的CPU时间百分比（设备带宽利用率）。 如果该值接近100%说明设备出现了瓶颈

#top用法
top - 11:01:50 up 133 days, 23:42,  1 user,  load average: 0.02, 0.02, 0.00
Tasks: 300 total,   1 running, 297 sleeping,   1 stopped,   1 zombie
Cpu0  :  0.6%us,  0.4%sy,  0.0%ni, 98.7%id,  0.1%wa,  0.0%hi,  0.1%si,  0.0%st
Cpu1  :  0.6%us,  0.5%sy,  0.0%ni, 98.8%id,  0.0%wa,  0.0%hi,  0.0%si,  0.0%st
Cpu2  :  0.3%us,  0.3%sy,  0.0%ni, 99.4%id,  0.0%wa,  0.0%hi,  0.0%si,  0.0%st
Cpu3  :  0.3%us,  0.2%sy,  0.0%ni, 99.5%id,  0.0%wa,  0.0%hi,  0.0%si,  0.0%st
Cpu4  :  0.7%us,  0.4%sy,  0.0%ni, 98.8%id,  0.1%wa,  0.0%hi,  0.1%si,  0.0%st
Cpu5  :  0.6%us,  0.5%sy,  0.0%ni, 98.8%id,  0.1%wa,  0.0%hi,  0.0%si,  0.0%st
Cpu6  :  0.3%us,  0.3%sy,  0.0%ni, 99.3%id,  0.0%wa,  0.0%hi,  0.0%si,  0.0%st
Cpu7  :  0.3%us,  0.2%sy,  0.0%ni, 99.5%id,  0.0%wa,  0.0%hi,  0.0%si,  0.0%st
Mem:   3087856k total,  2813980k used,   273876k free,   203844k buffers
Swap:  4063224k total,   361436k used,  3701788k free,  1379864k cached
  PID USER      PR  NI  VIRT  RES  SHR S %CPU %MEM    TIME+  COMMAND
21067 root      20   0 5769m 105m  776 S  3.7  3.5   6849:04 asd
 2873 root      20   0  466m 1516  464 S  1.9  0.0 178:55.07 gearmand
 4946 dev       20   0  387m 2032 1308 S  1.9  0.1   0:00.05 gearman-manager
 6702 dev       20   0 15168 1388  936 R  1.9  0.0   0:00.03 top
 9778 dev       20   0 4360m  89m 3172 S  1.9  3.0 194:27.77 beam.smp
14956 root      20   0  171m 1692  980 S  1.9  0.1   6:06.96 nmbd
18638 dev       20   0  169m  50m 1264 S  1.9  1.7 351:23.03 tmux
    1 root      20   0 19364  672  460 S  0.0  0.0   0:01.79 init
    2 root      20   0     0    0    0 S  0.0  0.0   0:00.06 kthreadd

Tasks行展示了目前的进程总数及所处状态，要注意zombie，表示僵尸进程，不为0则表示有进程出现问题。
Cpu(s)行展示了当前CPU的状态，us表示用户进程占用CPU比例，sy表示内核进程占用CPU比例，id表示空闲CPU百分比，wa表示IO等待所占用的CPU时间的百分比。wa占用超过30%则表示IO压力很大。
Mem行展示了当前内存的状态，total是总的内存大小，userd是已使用的，free是剩余的，buffers是目录缓存。
Swap行同Mem行，cached表示缓存，用户已打开的文件。如果Swap的used很高，则表示系统内存不足。
在top命令下，按shift + "p"，则将进程按照CPU使用率从大到小排序，按shift+"m"，则将进程按照内存使用率从大到小排序，很容易能够定位出哪些服务占用了较高的CPU和内存。


#分析程序中问题 
strace -cfp pid 统计耗时 哪个函数方法 占用系统资源大，可能出现不可预期的问题
oprofile软件    统计耗时 哪个函数方法 推荐使用
http://www.lenky.info/archives/2012/03/1371


#进程程序夯死
gdb跟进看卡到什么地方
http://www.akaedu.org/study/gdb.html
http://www.cnblogs.com/ggjucheng/archive/2011/12/14/2288004.html
