<?php

function error_handler_show() {
    echo "start error_handler_show" . PHP_EOL;
    print_r(func_get_args());
    echo "end error_handler_show" . PHP_EOL;
    return true;
}

function exception_handler_show() {
    echo "start exception_handler_show" . PHP_EOL;
    print_r(func_get_args());
    echo "end exception_handler_show" . PHP_EOL;
    return true;
}

set_error_handler("error_handler_show");
set_exception_handler("exception_handler_show");
