<?php

namespace App\Library;

class CryptUtil {

    private static $key = 'ebe0234ba12c3e78';

    public static function encryptId($data, $key = '') {
        $key = $key ? self::$key : md5($key, true);
        $en_data = self::encrypt(strval($data), $key);
        $en_data = substr($en_data, 0, -1);
        $result = str_replace(array('/', '+', '='), array('@', '#', '_'), $en_data);
        return bin2hex($result);
    }

    public static function decryptId($data, $key = '') {
        $key = $key ? self::$key : md5($key, true);
        $data = hex2bin($data);
        $data .= '=';
        $en_data = str_replace(array('@', '#', '_'), array('/', '+', '='), $data);
        $result = self::decrypt($en_data, $key);
        return $result;
    }

    public static function encrypt($input, $key) {
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $input = self::pkcs5Padding($input, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return base64_encode($data);
    }

    public static function decrypt($data, $key) {
        $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($data), MCRYPT_MODE_ECB);
        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s - 1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }

    public static function strToHex($string) {
        $hex = "";
        for ($i = 0; $i < strlen($string); $i++) {
            $hex .= dechex(ord($string[$i]));
        }
        return strtoupper($hex);
    }

    public static function hexToStr($hex) {
        $string = "";
        for ($i = 0; $i < strlen($hex) - 1; $i+=2) {
            $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
        }
        return $string;
    }

    private static function pkcs5Padding($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

}
