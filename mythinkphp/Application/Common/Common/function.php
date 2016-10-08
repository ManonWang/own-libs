<?php

use Common\Library\HttpUtil;

function output_css($key) {
    $assetInfo = C('asset');
    $assetVersion = C('assetVersion');
    $versionParam = C('versionParam');

    if (isset($assetInfo['css'][$key])) {
        $cssUrl = HttpUtil::urlAppendParams($assetInfo['css'][$key], array($versionParam => $assetVersion));
        return sprintf('<link href="%s" rel="stylesheet">' . PHP_EOL, $cssUrl);
    }
}

function output_js($key) {
    $assetInfo = C('asset');
    $assetVersion = C('assetVersion');
    $versionParam = C('versionParam');

    if (isset($assetInfo['js'][$key])) {
        $jsUrl = HttpUtil::urlAppendParams($assetInfo['js'][$key], array($versionParam => $assetVersion));
        return sprintf('<script src="%s"></script>' . PHP_EOL, $jsUrl);
    }
}

function data_pack($code, $error = '', $data = array()) {
    return array('code' => $code, 'error' => $error, 'data' => $data);
}

function is_succ_pack($data) {
    return $data['code'] == get_code('SUCC');
}

function get_code($key) {
    return Common\Library\CodesUtil::get($key);
}

function get_lang($key) {
    $params = func_get_args();
    $params[0] = Common\Library\LangsUtil::get($key);
    return call_user_func_array('sprintf', $params);
}

function p($data, $is_var_dump = false) {
    $is_var_dump ? var_dump($data) : print_r($data);
    echo PHP_EOL;
}
