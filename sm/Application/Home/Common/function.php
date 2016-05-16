<?php

function week_num2word($subject) {
    $search  = array(0, 1, 2, 3, 4, 5, 6);
    $replace = array('日', '一', '二', '三', '四', '五', '六');
    return str_replace($search, $replace, $subject);
}

function pack_data($code, $msg = '', $data = array()) {
    return array('code' => $code, 'msg' => $msg, 'data' => $data);
}

function get_curr_url($paged = false) {
    $urlInfo = parse_url($_SERVER['REQUEST_URI']);
    $url = 'http://' . $_SERVER['HTTP_HOST'] . $urlInfo['path'];
    parse_str($urlInfo['query'], $argsInfo);

    if ($paged) {
        unset($argsInfo['page']);
        $argsInfo['page'] = '';
    }

    return empty($argsInfo) ? $url : $url . '?' . http_build_query($argsInfo);
}

function get_star($risk_data, $risk_level) {
    $red_id    = $risk_level['level_2']['id']; //红线
    $orange_id = $risk_level['level_3']['id']; //甲1
    $yellow_id = $risk_level['level_4']['id']; //甲2

    $sum = 0;
    $score_map = array($red_id => 8, $orange_id => 4, $yellow_id => 1);
    foreach ($risk_data as $risk_level => $risk_count) {
        $sum += $score_map[$risk_level] * $risk_count;
    }

    $red = intval($sum / $score_map[$red_id]);
    $orange = intval(($sum - $red * $score_map[$red_id]) / $score_map[$orange_id]);
    $yellow = $sum - $red * $score_map[$red_id] - $orange * $score_map[$orange_id];
    return array('red' => $red, 'orange' => $orange, 'yellow' => $yellow);
}
