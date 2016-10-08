<?php

namespace MyPhalcon\App\Library;

use MyPhalcon\App\Library\HttpUtil;
use MyPhalcon\App\Library\LoggerUtil;

class AppInit {

    private static function url2Lower() {
        $_GET['_url'] = strtolower($_GET['_url']);
    }

    private static function initDebug() {
        $di = get_app_di();
        if ($di->get('config')->debug) {
            ini_set('display_errors', 'On');
            error_reporting(E_ALL & ~E_NOTICE);
        } else {
            ini_set('display_errors', 'Off');
            error_reporting(0);
        }
    }

    private static function setCharset() {
        header('Content-Type:text/html; charset=utf-8');
    }

    private static function setTimeZone() {
        date_default_timezone_set('PRC');
    }

    private static function logFatalError() {
         register_shutdown_function(function () {
              $error = error_get_last();
              switch($error['type']) {
                 case E_ERROR:
                 case E_PARSE:
                 case E_CORE_ERROR:
                 case E_COMPILE_ERROR:
                 case E_USER_ERROR:
                    LoggerUtil::fatal(json_encode($error, JSON_UNESCAPED_UNICODE));
              }
         });
    }

    private static function logReqInfo() {
        $data = array(
            'ip'      => HttpUtil::getClientIp(),
            'host'    => isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '',
            'uri'     => $_SERVER['REQUEST_URI'],
            'query'   => $_SERVER['QUERY_STRING'],
            'method'  => $_SERVER['REQUEST_METHOD'],
            'referer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
            'cookie'  => $_COOKIE,
            'params'  => $_REQUEST,
         );
         LoggerUtil::info(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    public static function initContext() {
        self::url2Lower();
        self::initDebug();
        self::setTimeZone();
        self::setCharset();
        self::logFatalError();
        self::logReqInfo();
    }

}
