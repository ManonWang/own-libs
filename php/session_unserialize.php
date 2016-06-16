<?php

$str = 'SESSION_LOGIN_CALLBACKURL|N;SESSION_USER_INFO|O:13:"Data_UserInfo":25:{s:3:"uid";i:200000466;s:8:"username";s:12:"m18910542509";s:4:"name";s:6:"王革";s:5:"money";s:4:"0.00";s:4:"idno";s:18:"43**************76";s:13:"idcard_passed";s:1:"1";s:12:"photo_passed";s:1:"0";s:6:"mobile";s:11:"189****2509";s:5:"email";N;s:7:"bank_no";s:19:"6222***********1971";s:4:"bank";s:12:"交通银行";s:9:"bank_code";s:5:"BOCOM";s:9:"bank_icon";s:93:"http://static.firstp2p.com/attachment/201407/30/16/c8165276305a81f4238302857e9a4aca/index.jpg";s:9:"bank_zone";s:0:"";s:7:"rescode";i:0;s:3:"sex";s:1:"1";s:6:"remain";s:4:"0.00";s:6:"frozen";s:4:"0.00";s:6:"income";s:4:"0.00";s:10:"earningAll";s:4:"0.00";s:6:"corpus";s:4:"0.00";s:5:"total";s:4:"0.00";s:5:"bonus";s:4:"0.00";s:9:"isO2oUser";i:1;s:14:"discountSwitch";i:1;}SESSION_USER_TOKEN|O:10:"Data_Token":3:{s:12:"access_token";s:32:"700baa46d4de5a25bc27f3050f6c8700";s:13:"refresh_token";s:32:"1f6d93df6ae8bd34a2358c4fce442667";s:10:"expires_in";i:1465558099;}';

define('PS_DELIMITER', '|');
define('PS_UNDEF_MARKER', '!');

function session_real_decode($str) {
    $str = (string) $str;

    $endptr = strlen($str);
    $p = 0;

    $serialized = '';
    $items = 0;
    $level = 0;

    while ($p < $endptr) {
        $q = $p;
        while ($str[$q] != PS_DELIMITER) {
            if (++$q >= $endptr) {
                break 2;
            }
        }

        if ($str[$p] == PS_UNDEF_MARKER) {
            $p++;
            $has_value = false;
        } else {
            $has_value = true;
        }

        $name = substr($str, $p, $q - $p);
        $q++;

        $serialized .= 's:' . strlen($name) . ':"' . $name . '";';

        if ($has_value) {
            for (;;) {
                $p = $q;
                switch ($str[$q]) {
                    case 'N': /* null */
                    case 'b': /* boolean */
                    case 'i': /* integer */
                    case 'd': /* decimal */
                        do {
                            $q++;
                        } while (($q < $endptr) && ($str[$q] != ';'));
                        $q++;
                        $serialized .= substr($str, $p, $q - $p);
                        if ($level == 0) {
                            break 2;
                        }
                        break;
                    case 'R': /* reference  */
                        $q+= 2;
                        for ($id = ''; ($q < $endptr) && ($str[$q] != ';'); $q++) {
                            $id .= $str[$q];
                        }
                        $q++;
                        $serialized .= 'R:' . ($id + 1) . ';'; /* increment pointer because of outer array */
                        if ($level == 0) {
                            break 2;
                        }
                        break;
                    case 's': /* string */
                        $q+=2;
                        for ($length = ''; ($q < $endptr) && ($str[$q] != ':'); $q++) {
                            $length .= $str[$q];
                        }
                        $q+=2;
                        $q+= (int) $length + 2;
                        $serialized .= substr($str, $p, $q - $p);
                        if ($level == 0) {
                            break 2;
                        }
                        break;
                    case 'a': /* array */
                    case 'O': /* object */
                        do {
                            $q++;
                        } while (($q < $endptr) && ($str[$q] != '{'));
                        $q++;
                        $level++;
                        $serialized .= substr($str, $p, $q - $p);
                        break;
                    case '}': /* end of array|object */
                        $q++;
                        $serialized .= substr($str, $p, $q - $p);
                        if (--$level == 0) {
                            break 2;
                        }
                        break;
                    default:
                        return false;
                }
            }
        } else {
            $serialized .= 'N;';
            $q+= 2;
        }
        $items++;
        $p = $q;
    }
    return @unserialize('a:' . $items . ':{' . $serialized . '}');
}

var_dump(session_real_decode($str));

