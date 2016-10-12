<?php

namespace App\Library;

class ArrayUtil {

    //查询结果集二维数组按照某个字段hash
    public static function hashByField($data, $field = 'id') {
        $return = array();
        foreach ($data as $item) {
            $return[$item[$field]] = $item;
        }
        return $return;
    }

    //查询结果集二维数组按照某个字段取值
    public static function getByField ($data, $field = 'id', $unique = true) {
        $return = array();
        foreach ($data as $item) {
            $return[] = $item[$field];
        }
        return $unique ? array_unique($return) : $return;

    }

}
