<?php
$siteconfig	=	require './siteconfig.inc.php';
$config	= array(
	/*
	 * 0:普通模式 (采用传统癿URL参数模式 )
	 * 1:PATHINFO模式(http://<serverName>/appName/module/action/id/1/)
	 * 2:REWRITE模式(PATHINFO模式基础上隐藏index.php)
	 * 3:兼容模式(普通模式和PATHINFO模式, 可以支持任何的运行环境, 如果你的环境不支持PATHINFO 请设置为3)
	 */
    'URL_MODEL'=>1,
	'DB_TYPE'=>'mysql',
    'DB_HOST'=>'localhost',
    'DB_NAME'=>'sm', //数据库
    'DB_USER'=>'root', //用户名
    'DB_PWD'=>'sa123456', //密码
	'DB_PORT'=>'3306',
	'DB_PREFIX'=>'',
	'PATH_IMG'=>"http://127.0.0.1/obj/", //根目录
	
	
	'APP_AUTOLOAD_PATH'=>'@.TagLib',
	'SESSION_AUTO_START'=>true,
	'VAR_PAGE'=>'pageNum',
	'USER_AUTH_GATEWAY'=>'/Public/login',	// 默认认证网关
	'NOT_AUTH_MODULE'=>'Public',	

);

return array_merge($config,$siteconfig);
?>