<?php

namespace Common\Library;

require VENDOR_PATH . '/log4php/Logger.php';
\Logger::configure(C('LOGGER_CONFIG'));

class LoggerUtil {

    private static $logId   = '';

    public static function trace($content){
        $logger = self::getLogger();
        return $logger->trace(self::logFormat($content));
    }

    public static function debug($content){
        $logger = self::getLogger();
        return $logger->debug(self::logFormat($content));
    }

    public static function info($content){
        $logger = self::getLogger();
        return $logger->info(self::logFormat($content));
    }

    public static function warn($content){
        $logger = self::getLogger();
        return $logger->warn(self::logFormat($content));
    }

    public static function error($content){
        $logger = self::getLogger();
        return $logger->error(self::logFormat($content));
    }

    public static function fatal($content){
        $logger = self::getLogger();
        return $logger->fatal(self::logFormat($content));
    }

    private static function logFormat($content){
        if (!is_string($content)) {
            $content = json_encode($content, JSON_UNESCAPED_UNICODE);
        }

        $content = strtr($content, "\n", ' ');

        $backtrace = debug_backtrace();
        $file = isset($backtrace[1]['file']) ? basename($backtrace[1]['file']) : '';
        $line = isset($backtrace[1]['line']) ? $backtrace[1]['line'] : '';

        list($msec, $sec) = explode(' ', microtime(), 2);
        $currentTime = date('H:i:s', $sec) . '.' . intval($msec * 1000);

        return "[$currentTime] [" . self::getLogId() . "] [{$file}:{$line}] {$content}";
    }

    private static function getLogId() {
        if (empty(self::$logId)) {
            self::$logId = sprintf('%x', (intval(microtime(true) * 10000) % 864000000) * 10000 + mt_rand(100000, 999999));
        }

        return self::$logId;
    }

    private static function getLogger() {
        return \Logger::getLogger(__CLASS__);
    }

}
