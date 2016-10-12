<?php

use App\Config\ServiceConfig;
use App\Library\AppInit;
use App\Library\HttpUtil;
use App\Library\LoggerUtil;

//定义项目的根目录
define('IS_CLI_APP', false);
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

//执行请求
try {
    run_cgi_application();
} catch (\Exception $e) {
    LoggerUtil::error($e->getMessage());
    HttpUtil::redirect('/errors/show500');
}
