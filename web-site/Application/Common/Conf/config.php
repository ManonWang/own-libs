<?php

return array(

	'SHOW_PAGE_TRACE' => true,
	'URL_CASE_INSENSITIVE' => false,
	'URL_MODEL'  => 2,

    'DEFAULT_TIMEZONE' => 'Asia/Shanghai',
	'TMPL_L_DELIM'=>'<{',
	'TMPL_R_DELIM'=>'}>',

    'LOG_RECORD' => true,
    'LOG_TYPE'   => 'Sae',
    'LOG_LEVEL'  =>'EMERG,ERR,WARN,INFO',
    
	'DB_PREFIX' => '',
	'DB_TYPE' => 'mysql',
	'DB_NAME' => 'web_site',
	'DB_HOST' => defined('SAE_MYSQL_HOST_M') ? SAE_MYSQL_HOST_M . "," . SAE_MYSQL_HOST_S  : '127.0.0.1',
	'DB_PORT' => defined('SAE_MYSQL_PORT')   ? SAE_MYSQL_PORT   : '3306',
	'DB_USER' => defined('SAE_MYSQL_USER')   ? SAE_MYSQL_USER   : 'root',
	'DB_PWD'  => defined('SAE_MYSQL_PASS')   ? SAE_MYSQL_PASS   : 'MhxzKhl',
    'DB_RW_SEPARATE'=>true,

);
