#!/bin/bash

while read line
do
    file=`readlink -e $line`
    echo "process file : $file"
    sed -i -r '1,$s/\t/    /g'  $file
    sed -i -r '1,$s/\s{1,}$//g' $file
done
