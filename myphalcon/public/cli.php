<?php

use App\Config\ServiceConfig;
use App\Library\AppInit;

//定义项目的根目录
define('IS_CLI_APP', true);
define('ROOT_PATH', dirname(__DIR__));

//引入自定义函数
require ROOT_PATH . '/app/library/functions.php';

//常量定义
init_app_constant();

//引入自动加载
init_app_autoload();

//初始化容器
init_app_di();

//注册服务
ServiceConfig::register();

//初始化的一系列操作
AppInit::initContext();

//执行任务
try {
    run_cli_application($argv);
} catch (\Exception $e) {
    p($e->getMessage());
    exit(255);
}
