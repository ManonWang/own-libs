<?php

function is_mobile_device() {
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    } 

    if (isset($_SERVER['HTTP_VIA'])) {
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    } 

    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientKeywords = array(
             'nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic',
             'alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb',
             'windowsce','palm','operamini','operamobi','openwave','nexusone','cldc', 'midp','wap','mobile'
        );
        if (preg_match("/(" . implode('|', $clientKeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        } 
    } 

    if (isset($_SERVER['HTTP_ACCEPT'])) { 
        $keywordPos = strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml');
        $acceptPos  = strpos($_SERVER['HTTP_ACCEPT'], 'text/html');
        if (false !== $keywordPos && (false === $acceptPos || $keywordPos < $acceptPos)) {
            return true;
        } 
    }

    return false;
} 

function get_theme() {
    return is_mobile_device() ? 'wap' : 'pc';
}

function get_assets_url($key) {
    $assets = C('ASSETS');
    if (!isset($assets[$key])) {
        return ;
    }

    $version = C('ASSETS_VERSION');

    $asset = $assets[$key];
    if ('http' == substr($asset, 0, 4) || '//' == substr($asset, 0, 2)) {
        $url = $asset . '?v=' . $version;
    } else {
        $host  = C('ASSETS_PERFIX');
        $url = $host . $asset . '?v=' . $version;
    }   

    return str_replace(':platform:', C('DEFAULT_THEME'), $url);
}
