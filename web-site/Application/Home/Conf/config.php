<?php

return array(
    
    'DEFAULT_THEME' => 'pc',
    'TMPL_L_DELIM'=>'<{',
    'TMPL_R_DELIM'=>'}>',

    'ASSETS_VERSION' => "20160303",
    'ASSETS_PERFIX'  => "http://{$_SERVER['HTTP_HOST']}",
    'ASSETS' => array(
       'css_bootstrap' => '/Public/static/:platform:/vendor/bootstrap/css/bootstrap.min.css',
       'css_mainsite'  => '/Public/static/:platform:/css/mainsite.css', 

       'js_html5shiv'  => '/Public/static/:platform:/vendor/bootstrap/js/html5shiv.min.js', 
       'js_respond'    => '/Public/static/:platform:/vendor/bootstrap/js/respond.min.js', 
       'js_jquery'     => '/Public/static/:platform:/vendor/jquery/jquery.min.js', 
       'js_bootstrap'  => '/Public/static/:platform:/vendor/bootstrap/js/bootstrap.min.js', 

       'img_logo'      => '/Public/static/:platform:/img/logo.png',
       'img_bar'       => '/Public/static/:platform:/img/bar.jpg',   
     ),

);
