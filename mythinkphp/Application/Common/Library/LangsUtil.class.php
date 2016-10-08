<?php

namespace Common\Library;

LangsUtil::setLang(LangsUtil::LANG_ZH);
LangsUtil::setData(CONFIG_PATH . '/langs.php');

class LangsUtil {

    const LANG_ZH = 'zh';
    const LANG_EN = 'en';

    public static $lang = self::LANG_ZH;
    public static $data = array();

    public static function setLang($lang) {
        self::$lang = $lang;
    }

    public static function getLang() {
        return self::$lang;
    }

    public static function setData($data) {
        self::$data = is_array($data) ? $data : require($data);
    }

    public static function getData() {
        return self::$data;
    }

    public static function get($key) {
        if (isset(self::$data[self::$lang][$key])) {
            return self::$data[self::$lang][$key];
        }

        throw new \Exception(sprintf(self::get('LANGS_KEY_NOT_FOUND'), $key));
    }

}
