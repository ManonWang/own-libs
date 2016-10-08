<?php

namespace Common\Library;

class AppInitBehavior extends \Think\Behavior {

    private function definedConst() {
        define('CONFIG_PATH', realpath(APP_PATH) . '/' . MODULE_NAME . '/Conf');
    }

    private function initDebug() {
        if (C('APP_DEBUG')) {
            ini_set('display_errors', 'On');
            error_reporting(E_ALL & ~E_NOTICE);
        } else {
            ini_set('display_errors', 'Off');
            error_reporting(0);
        }
    }

    private function setCharset() {
        header('Content-Type:text/html; charset=utf-8');
    }

    private function setTimeZone() {
        date_default_timezone_set('PRC');
    }

    private function logFatalError() {
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

    private function logReqInfo() {
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

    public function run(&$param){
        $this->definedConst();
        $this->initDebug();
        $this->setTimeZone();
        $this->setCharset();
        $this->logFatalError();
        $this->logReqInfo();
    }

}
