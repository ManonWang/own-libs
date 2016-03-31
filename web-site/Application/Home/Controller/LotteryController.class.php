<?php

namespace Home\Controller;

class LotteryController extends BaseController {
    
    private $result = array();

    private $source = array(
        'type_1' => array(
            'name' => '特码合并', 
            'link' => 'http://www.website.com/lottery/combine',
            'example' => '26.38.16.28.40.27.39.08.20.32.44.21.33.18.42',
         ), 
        /*
        'type_2' => array(
            'name' => '欢乐特肖',
            'link' => 'http://www.022822.com/mode.php?m=o&q=user&u=3512',
            'example' => '兔牛羊虎',
         ),*/
        'type_3' => array(
            'name' => '长白子山', 
            'link' => 'http://www.022822.com/mode.php?m=o&q=user&u=3491',
            'example' => '蓝绿',
         ),
        'type_5' => array(
            'name' => '安心定志',
            'link' => 'http://www.022822.com/mode.php?m=o&q=user&u=3528',
            'example' => '双数'
         ),
        'type_2' => array(
            'name' => '再次见你',
            'link' => 'http://www.022822.com/mode.php?m=o&q=user&u=3453',
            'example' => '牛猪狗猴龙兔',
         ),
        'type_4' => array(
            'name' => '女人歌手',
            'link' => 'http://www.022822.com/mode.php?m=o&q=user&u=3430',
            'example' => '合双',
         ),
    );

    private $data = array(
        '01' => array('color' => '红', 'zodiac' => '猴', 'sum' => '合单', 'type' => '单数'),        
        '02' => array('color' => '红', 'zodiac' => '羊', 'sum' => '合双', 'type' => '双数'),        
        '03' => array('color' => '蓝', 'zodiac' => '马', 'sum' => '合单', 'type' => '单数'),        
        '04' => array('color' => '蓝', 'zodiac' => '蛇', 'sum' => '合双', 'type' => '双数'),        
        '05' => array('color' => '绿', 'zodiac' => '龙', 'sum' => '合单', 'type' => '单数'),        
        '06' => array('color' => '绿', 'zodiac' => '兔', 'sum' => '合双', 'type' => '双数'),        
        '07' => array('color' => '红', 'zodiac' => '虎', 'sum' => '合单', 'type' => '单数'),        
        '08' => array('color' => '红', 'zodiac' => '牛', 'sum' => '合双', 'type' => '双数'),        
        '09' => array('color' => '蓝', 'zodiac' => '鼠', 'sum' => '合单', 'type' => '单数'),        
        '10' => array('color' => '蓝', 'zodiac' => '猪', 'sum' => '合单', 'type' => '双数'),        
        '11' => array('color' => '绿', 'zodiac' => '狗', 'sum' => '合双', 'type' => '单数'),        
        '12' => array('color' => '红', 'zodiac' => '鸡', 'sum' => '合单', 'type' => '双数'),        
        '13' => array('color' => '红', 'zodiac' => '猴', 'sum' => '合双', 'type' => '单数'),        
        '14' => array('color' => '蓝', 'zodiac' => '羊', 'sum' => '合单', 'type' => '双数'),        
        '15' => array('color' => '蓝', 'zodiac' => '马', 'sum' => '合双', 'type' => '单数'),        
        '16' => array('color' => '绿', 'zodiac' => '蛇', 'sum' => '合单', 'type' => '双数'),        
        '17' => array('color' => '绿', 'zodiac' => '龙', 'sum' => '合双', 'type' => '单数'),        
        '18' => array('color' => '红', 'zodiac' => '兔', 'sum' => '合单', 'type' => '双数'),        
        '19' => array('color' => '红', 'zodiac' => '虎', 'sum' => '合双', 'type' => '单数'),        
        '20' => array('color' => '蓝', 'zodiac' => '牛', 'sum' => '合双', 'type' => '双数'),        
        '21' => array('color' => '绿', 'zodiac' => '鼠', 'sum' => '合单', 'type' => '单数'),        
        '22' => array('color' => '绿', 'zodiac' => '猪', 'sum' => '合双', 'type' => '双数'),        
        '23' => array('color' => '红', 'zodiac' => '狗', 'sum' => '合单', 'type' => '单数'),        
        '24' => array('color' => '红', 'zodiac' => '鸡', 'sum' => '合双', 'type' => '双数'),        
        '25' => array('color' => '蓝', 'zodiac' => '猴', 'sum' => '合单', 'type' => '单数'),        
        '26' => array('color' => '蓝', 'zodiac' => '羊', 'sum' => '合双', 'type' => '双数'),        
        '27' => array('color' => '绿', 'zodiac' => '马', 'sum' => '合单', 'type' => '单数'),        
        '28' => array('color' => '绿', 'zodiac' => '蛇', 'sum' => '合双', 'type' => '双数'),        
        '29' => array('color' => '红', 'zodiac' => '龙', 'sum' => '合单', 'type' => '单数'),        
        '30' => array('color' => '红', 'zodiac' => '兔', 'sum' => '合单', 'type' => '双数'),        
        '31' => array('color' => '蓝', 'zodiac' => '虎', 'sum' => '合双', 'type' => '单数'),        
        '32' => array('color' => '绿', 'zodiac' => '牛', 'sum' => '合单', 'type' => '双数'),        
        '33' => array('color' => '绿', 'zodiac' => '鼠', 'sum' => '合双', 'type' => '单数'),        
        '34' => array('color' => '红', 'zodiac' => '猪', 'sum' => '合单', 'type' => '双数'),        
        '35' => array('color' => '红', 'zodiac' => '狗', 'sum' => '合双', 'type' => '单数'),        
        '36' => array('color' => '蓝', 'zodiac' => '鸡', 'sum' => '合单', 'type' => '双数'),        
        '37' => array('color' => '蓝', 'zodiac' => '猴', 'sum' => '合双', 'type' => '单数'),        
        '38' => array('color' => '绿', 'zodiac' => '羊', 'sum' => '合单', 'type' => '双数'),        
        '39' => array('color' => '绿', 'zodiac' => '马', 'sum' => '合双', 'type' => '单数'),        
        '40' => array('color' => '红', 'zodiac' => '蛇', 'sum' => '合双', 'type' => '双数'),        
        '41' => array('color' => '蓝', 'zodiac' => '龙', 'sum' => '合单', 'type' => '单数'),        
        '42' => array('color' => '蓝', 'zodiac' => '兔', 'sum' => '合双', 'type' => '双数'),        
        '43' => array('color' => '绿', 'zodiac' => '虎', 'sum' => '合单', 'type' => '单数'),        
        '44' => array('color' => '绿', 'zodiac' => '牛', 'sum' => '合双', 'type' => '双数'),        
        '45' => array('color' => '红', 'zodiac' => '鼠', 'sum' => '合单', 'type' => '单数'),        
        '46' => array('color' => '红', 'zodiac' => '猪', 'sum' => '合双', 'type' => '双数'),        
        '47' => array('color' => '蓝', 'zodiac' => '狗', 'sum' => '合单', 'type' => '单数'),        
        '48' => array('color' => '蓝', 'zodiac' => '鸡', 'sum' => '合双', 'type' => '双数'),        
        '49' => array('color' => '绿', 'zodiac' => '猴', 'sum' => '合单', 'type' => '单数'),        
    );

    public function index() {
        $list = M('LotteryGuess')->distinct(true)->field('batch_num')->order('batch_num desc')->limit(30)->select();
        $this->assign("list", $list);
        $this->display();
    }

    public function show() {
        $this->argsFillBack();
        $this->dataFillBack();
        $this->assign("source", $this->source);
        $this->display();
    }
    
    public function result() {
        $this->result = array();
        $batchNum = trim(I('batch_num'));
        $one = M('LotteryGuess')->where(array('batch_num' => $batchNum))->limit(1)->find();
        if ($one['real_result'] <= 0) { 
            M('LotteryGuess')->where(array('batch_num' => $batchNum))->delete();
        }

        foreach (I() as $key => $value) {
            if (false === strpos($key, 'type_')) {
                continue;
            }

            $guessCxt = trim($value);
            $data = array('batch_num'=>$batchNum, 'guess_cxt'=>$guessCxt, 'guess_res'=>-1, 'real_result'=>'0', 'source_type'=>trim($key));
            if ($one['real_result'] <= 0) {
                D('LotteryGuess')->data($data)->add();
            }

            $method = "fx_$key";
            $this->$method($guessCxt);
        }
        
        $rates = array();
        foreach ($this->result as $key => $item) {
            $rates[$key] = $item['rate'];
        }
        arsort($rates);

        $result = array();
        foreach ($rates as $key => $val) {
            $result[$key] = $this->result[$key];
        }

        $this->assign('result', $result);
        $this->assign('data', $this->data);
        $this->display();
    }
    
    public function combine() {
        $ball = array();
        foreach (I() as $key => $val) {
            if (false === strpos($key, 'sp_')) {
                continue;
            }
            $val = str_replace(array('-', '.', ','), ' ', trim($val));
            foreach (explode(' ', $val) as $item) {
                $item = trim($item);
                if ($item > 0) {
                    $num = sprintf("%02d", $item);
                    $ball[$num] = 1;
                }
            }
        }

        $this->argsFillBack();
        $this->assign('result', implode('.', array_keys($ball)));
        $this->display();
    }

    public function check() {
        $one = M('LotteryGuess')->where(array('real_result' => 0))->order("batch_num DESC")->limit(1)->find();
        $content = file_get_contents('http://55kj.com/chajian/bmjg.js?_=' . time());
        if (!preg_match_all('~(\d{3})(,\d{2}){7}~', $content, $matches) || empty($matches)) {
            return ;
        }
        
        $batchNum = date('Y') . trim($matches[1][0]);
        $realRes  = sprintf("%02d", ltrim(trim($matches[2][0]), ','));
        if ($one['batch_num'] != $batchNum) {
            return ;
        }

        $ball = $this->data[$realRes];
        $data = M('LotteryGuess')->where(array('batch_num' => $batchNum))->select();
        foreach ($data as $item) {
            $item['real_result'] = $realRes;
            $item['guess_res'] = intval(strpos($item['guess_cxt'], $realRes) !== false || 
                strpos($item['guess_cxt'], $ball['color'])  !== false || 
                strpos($item['guess_cxt'], $ball['zodiac']) !== false ||
                strpos($item['guess_cxt'], $ball['sum'])    !== false);
            M('LotteryGuess')->data($item)->save();
        }
    }

    private function fx_type_1($data, $alpha = 1) {
        $data = preg_split('~(\.|\-)~', $data);
        foreach ($data as $key => $val) {
            $data[$key] = sprintf("%02d", trim($val));
        }

        for($num = 1; $num <= 49; $num ++) {
            $ball = sprintf("%02d", $num);
            if (in_array($ball, $data)) {
                $this->result[$ball]['rate'] = $this->result[$ball]['rate'] + 1 * $alpha;
                $this->result[$ball]['number'] = true;
            } else {
                $this->result[$ball]['rate'] = $this->result[$ball]['rate'] + 0;
                $this->result[$ball]['number'] = false;
            }
        }
    }

    private function fx_type_2($data, $alpha = 1) {
        $data = preg_split('/(?<!^)(?!$)/u', $data);
        for($num = 1; $num <= 49; $num ++) {
            $ball = sprintf("%02d", $num);
            $zodiac = $this->data[$ball]['zodiac'];
            if (in_array($zodiac, $data)) {
                $this->result[$ball]['rate'] = $this->result[$ball]['rate'] + 1 * $alpha;
                $this->result[$ball]['zodiac'] = true;
            } else {
                $this->result[$ball]['rate'] = $this->result[$ball]['rate'] + 0;
                $this->result[$ball]['zodiac'] = false;
            }
        }
    }

    private function fx_type_3($data, $alpha = 1) {
        $data = preg_split('/(?<!^)(?!$)/u', $data);
        for($num = 1; $num <= 49; $num ++) {
            $ball = sprintf("%02d", $num);
            $color = $this->data[$ball]['color'];
            if (in_array($color, $data)) {
                $this->result[$ball]['rate'] = $this->result[$ball]['rate'] + 1 * $alpha;
                $this->result[$ball]['color'] = true;
            } else {
                $this->result[$ball]['rate'] = $this->result[$ball]['rate'] + 0;
                $this->result[$ball]['color'] = false;
            }
        }
    }

    private function fx_type_4($data, $alpha = 1) {
        for($num = 1; $num <= 49; $num ++) {
            $ball = sprintf("%02d", $num);
            $sum = $this->data[$ball]['sum'];
            if ($sum == $data) {
                $this->result[$ball]['rate'] = $this->result[$ball]['rate'] + 1 * $alpha;
                $this->result[$ball]['sum'] = true;
            } else {
                $this->result[$ball]['rate'] = $this->result[$ball]['rate'] + 0;
                $this->result[$ball]['sum'] = false;
            }
        }
    }

    private function fx_type_5($data, $alpha = 1) {
        for($num = 1; $num <= 49; $num ++) {
            $ball = sprintf("%02d", $num);
            $type = $this->data[$ball]['type'];
            if ($type == $data) {
                $this->result[$ball]['rate'] = $this->result[$ball]['rate'] + 1 * $alpha;
                $this->result[$ball]['type'] = true;
            } else {
                $this->result[$ball]['rate'] = $this->result[$ball]['rate'] + 0;
                $this->result[$ball]['type'] = false;
            }
        }
    }

    private function dataFillBack() {
        $batchNum = trim(I('batch_num'));
        if (empty($batchNum)) {
            return ;
        }

        $show = $this->getBatchData($batchNum);
        $this->assign('show', $show);

        $curr = current($show);
        if ($curr['real_result'] > 0) {
            $this->assign('ball', $this->data[$curr['real_result']]);
        }
    }

    private function getBatchData($batchNum) {
        $show = array();
        $data = M('LotteryGuess')->where(array('batch_num' => $batchNum))->select();
        foreach ($data as $item) {
            $show[$item['source_type']] = $item;
        }
        return $show;
    }


    private function argsFillBack() {
        foreach (I() as $key => $val) {
            $this->assign($key, $val);
        }
    } 

}
