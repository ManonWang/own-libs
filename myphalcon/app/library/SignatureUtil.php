<?php

namespace App\Library;

use App\Library\LoggerUtil;

class SignatureUtil {

    /**
     * 检查用户时间和本系统时间差
     * @param $timestamp
     * @param $diff
     * @return bool
     */
    public static function checkTimestamp($timestamp, $diff = 600) {
       return abs(time() - $timestamp) <= $diff;
    }

    /**
     * @业务系统校验签名
     * @param  array  $params
     * @param  string $secret
     * @param  string $sign
     * @return bool
     */
    public static function checkAPISign($params, $secret, $sign, $ignore = array()) {
        $signMd5 = self::createAPISign($params, $secret, $ignore);
        if (strtolower($signMd5) == strtolower($sign)) {
            return true;
        }

        return false;
    }

    /**
     * @业务系统生成签名
     * @param   array   $params
     * @param   string  $secret
     * @return  string
     */
    public static function createAPISign($params, $secret, $ignore = array()) {
        foreach ($ignore as $field) {
            unset($params[$field]);
        }

        ksort($params);
        $sortedReq = $secret;
        foreach ($params as $key => $val) {
            $sortedReq .= ($key . $val);
        }

        $sortedReq .= $secret;

        LoggerUtil::info($sortedReq);

        return strtolower(md5($sortedReq));
    }

}
