#!/bin/bash

echo "索引数组"

data=(1 2 3 4 5) #定义

data[1]=6  #赋值

echo ${data[1]} #取值

echo ${#data[@]} #取数组元素个数

echo ${data[@]} #取数组所有

for item in ${data[@]}
do
    echo -n "$item "
done


echo -e "\n关联数组"

#声明
declare -A arr 

arr=([a]=1 [b]=2 [c]=3) #定义

arr[b]=4 #赋值

echo ${arr[b]} #取值

echo ${#arr[@]} #元素个数

echo ${arr[@]} #所有元素值

echo ${!arr[@]} #所有键值
