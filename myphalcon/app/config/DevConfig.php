<?php

return array(

   'debug' => true,

   'logger' => array(
        'file' => array(
           'path' => ''
         )
    ),

   'view' => array(
        'templatePath' => VIEWS_PATH,
        'compiledPath' => CACHE_PATH . '/views/',
        'compiledExtension' => '.compiled',
        'compileAlways' => true,
        'autoEscape' => true,
    ),

   'versionParam' => 'version',
   'assetVersion' => '20160906',
   'asset' => array(
        'js' => array(
            'jquery' => '/static/vendor/jquery/jquery.min.js',
            'bootstrap' => '/static/vendor/bootstrap/js/bootstrap.min.js',
            'html5shiv' => '/static/vendor/bootstrap/js/html5shiv.min.js',
            'respond' => '/static/vendor/bootstrap/js/respond.min.js',
         ),
        'css' => array(
            'bootstrap' => '/static/vendor/bootstrap/css/bootstrap.min.css',
         )
    ),

   'metaData' => array(
        'saveType' => 'file',
        'savePath' => CACHE_PATH . '/metadata/',
    ),

   'redisCache' => array(
        'host' => '127.0.0.1',
        'port' => '6379',
    ),

   'mysql' => array(
        'myPhalcon_w' => array(
            'host'      => '127.0.0.1',
            'username'  => 'root',
            'password'  => 'MhxzKhl',
            'dbname'    => 'myphalcon',
            'port'      => '3306'
         ),
        'myPhalcon_r' => array(
            'host'      => '127.0.0.1',
            'username'  => 'root',
            'password'  => 'MhxzKhl',
            'dbname'    => 'myphalcon',
            'port'      => '3306'
         ),
    ),

   'block' => array(
       'login_fail' => array( //登录错误次数限制
            'type'   => 2, // 1: 严格限制  2: 非严格限制
            'prefix' => 'login_fail_block_by_',
            'rules'  => array('60' => '3', '300' => '10', '900' => '25'),
        ),
    ),

   'rpcUri' => 'http://www.myphalcon.com/rpc',
);
