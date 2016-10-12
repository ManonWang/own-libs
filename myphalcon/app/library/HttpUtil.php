<?php

namespace App\Library;

class HttpUtil {

    public static function getUrlInfo($url, $parseParams = true) {
        $urlInfo = parse_url($url);
        if ($parseParams) {
            parse_str($urlInfo['query'], $urlParams);
            $urlInfo['params'] = $urlParams;
        }
        return $urlInfo;
    }

    public static function redirect($url, $second = 0) {
        $content = sprintf('refresh:%s; url=%s', $second, $url);
        header($content);
    }

    public static function urlAppendParams($url, $params) {
        $params = is_array($params) ? http_build_query($params) : urlencode($params);
        return false != strpos($url, '?') ? $url . '&' . $params : $url . '?' . $params;
    }

    public static function getRefererUrl() {
        return $_SERVER['HTTP_REFERER'];
    }

    public static function getIndexUrl() {
        return '/';
    }

    public static function getClientIp() {
        $unknown = 'unknown';

        $field = 'HTTP_CLIENT_IP';
        if (getenv($field) && strcasecmp(getenv($field), $unknown)) {
            return getenv($field);
        }

        $field = 'HTTP_X_FORWARDED_FOR';
        if (getenv($field) && strcasecmp(getenv($field), $unknown)) {
            return getenv($field);
        }

        $field = 'REMOTE_ADDR';
        if (getenv($field) && strcasecmp(getenv($field), $unknown)) {
            return getenv($field);
        }

        $field = 'REMOTE_ADDR';
        if ($_SERVER[$field] && strcasecmp($_SERVER [$field], $unknown)) {
            return $_SERVER[$field];
        }

        return $unknown;
    }

}
