<?php

return array(

    'APP_DEBUG' => false,
    'SHOW_PAGE_TRACE' => false,

    'URL_CASE_INSENSITIVE' => false,
    'URL_MODEL'  => 2,

    'DEFAULT_TIMEZONE' => 'Asia/Shanghai',
    'TMPL_L_DELIM'=>'<{',
    'TMPL_R_DELIM'=>'}>',

    'LOG_RECORD' => false,
    'LOGGER_CONFIG' => require('log4php.php'),

    'versionParam' => 'version',
    'assetVersion' => '20160906',
    'asset' => array(
        'js' => array(
            'jquery'    => '/static/vendor/jquery/jquery.min.js',
            'bootstrap' => '/static/vendor/bootstrap/js/bootstrap.min.js',
            'html5shiv' => '/static/vendor/bootstrap/js/html5shiv.min.js',
            'respond'   => '/static/vendor/bootstrap/js/respond.min.js',
         ),
        'css' => array(
            'bootstrap' => '/static/vendor/bootstrap/css/bootstrap.min.css',
         )
    ),

   'RPC_URI' => 'http://www.mythinkphp.com/rpc/index',
   'ERROR_PAGE' => '/Errors/show500',

   'myphalcon' => array(
      'DB_RW_SEPARATE' => true,
      'DB_DEPLOY_TYPE' => 1,
      'DB_TYPE'        => 'mysql',
      'DB_HOST'        => '127.0.0.1',
      'DB_PORT'        => '3306',
      'DB_USER'        => 'root',
      'DB_PWD'         => 'MhxzKhl',
      'DB_NAME'        => 'myphalcon',
      'DB_CHARSET'     => 'utf8',
      'DB_PREFIX'      => '',
   ),

);
