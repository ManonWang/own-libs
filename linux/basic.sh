#!/bin/bash -xv

#系统
echo $UID #0
echo $@ #取所有参数
echo $# #参数个数
echo $? #上次执行结果
echo $0 #文件名

#字符串
str="abcdefg.jpg"
echo ${#str}          #长度
echo ${str:1:2}       #截取
echo ${str/de/ }      #替换
echo $str | grep 'de' #存在
echo ${str%.*}   #取文件名 %表示从右边向左边匹配, 匹配到.为止，非贪婪 %%贪婪
echo ${str#*.}   #取扩展名 #表示从左边向右边匹配，匹配到.为止，非贪婪 ##贪婪

#判断
str="abccdefa" 
[ $str =~ "be" ] #包含
if [ "a" == "b" ] || [ "c" == "c" ]; 
then 
    echo 1
fi

#序列
echo {1..10}
echo {a..z}

#日期
date --date "-1 day" "+%F %T"

#读取
read -n 读字符数
read -s 不回显 读密码
read -p 提示
read -t 时间
