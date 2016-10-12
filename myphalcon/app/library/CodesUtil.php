<?php

namespace App\Library;

CodesUtil::setData(CONFIG_PATH . '/CodesConfig.php');

class CodesUtil {

    public static $data = array();

    public static function setData($data) {
        self::$data = is_array($data) ? $data : require($data);
    }

    public static function getData() {
        return self::$data;
    }

    public static function get($key) {
        if (isset(self::$data[$key])) {
            return self::$data[$key];
        }

        throw new \Exception(get_lang('CODES_KEY_NOT_FOUND', $key));
    }

}
