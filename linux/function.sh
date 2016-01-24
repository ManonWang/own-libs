#!/bin/bash -xv

function test() 
{
    echo $3
    echo $@
    echo $#
    return 8
}

test abc ef "g hi"
echo $?
