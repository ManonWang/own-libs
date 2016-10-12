<?php

namespace App\Library;

class DateUtil {

    /**
     * 日期的时间戳 1474621622
     */
    protected $timestamp;

    /**
     * 年 2016
     */
    protected $year;

    /**
     * 月 1-12
     */
    protected $month;

    /**
     * 日 1-31
     */
    protected $day;

    /**
     * 时 0-23
     */
    protected $hour;

    /**
     * 分 0-59
     */
    protected $minute;

    /**
     * 秒 0-59
     */
    protected $second;

    /**
     * 星期的数字表示 0-6
     */
    protected $weekday;

    /**
     * 星期的完整表示  星期日-星期六
     */
    protected $cWeekday;

    /**
     * 一年中的天数 0-365
     */
    protected $yDay;

    /**
     * 月份的完整表示 January-December
     */
    protected $cMonth;

    /**
     * 日期cDate表示 2016-09-03
     */
    protected $cDate;

    /**
     * 日期的ymd表示 20160903
     */
    protected $ymd;

    /**
     * 时间的输出表示 17:07:02
     */
    protected $cTime;

    /**
     * 星期的输出
     */
    protected $week = array("日", "一", "二", "三", "四", "五", "六");

    /**
     * 构造函数
     * @param mixed $date  日期
     */
    public function __construct($date = '') {
        $this->timestamp = $this->parse($date);
        $this->setDate($this->timestamp);
    }

    /**
     * 日期分析 返回时间戳
     * @param mixed $date 日期
     * @return string
     */
    public function parse($date) {
        if (is_null($date)) {
            return time();
        }

        if (is_string($date)) {
            return empty($date) || !strtotime($date) ? time() : strtotime($date);
        }

        if (is_numeric($date)) {
            return $date;
        }

        return time();
    }

    /**
     * 日期参数设置
     * @param integer $date  日期时间戳
     */
    public function setDate($date) {
        $dateArray = getdate($date);

        $this->timestamp = $dateArray[0];            //时间戳
        $this->second = $dateArray["seconds"];       //秒
        $this->minute = $dateArray["minutes"];       //分
        $this->hour = $dateArray["hours"];           //时
        $this->day = $dateArray["mday"];             //日
        $this->month = $dateArray["mon"];            //月
        $this->year = $dateArray["year"];            //年

        $this->weekday = $dateArray["wday"];         //星期 0～6
        $this->cWeekday = '星期' . $this->week[$this->weekday];  //星期完整表示

        $this->yDay = $dateArray["yday"];         //一年中的天数 0－365
        $this->cMonth = $dateArray["month"];      //月份的完整表示

        $this->cDate = $this->format("Y-m-d");  //日期表示
        $this->cTime = $this->format("H:i:s");  //时间表示
        $this->ymd = $this->format("Ymd");      //简单日期
    }

    /**
     * 日期格式化
     * 默认返回 1970-01-01 11:30:45 格式
     * @param string $format  格式化参数
     * @return string
     */
    public function format($format = "Y-m-d H:i:s") {
        return date($format, $this->timestamp);
    }

    /**
     * 是否为闰年
     * @return bool
     */
    public function isLeapYear($year = '') {
        if (empty($year)) {
            $year = $this->year;
        }
        return ((($year % 4) == 0) && (($year % 100) != 0) || (($year % 400) == 0));
    }

    /**
     * 计算日期差
     *
     *  y - year
     *  M - month
     *  w - weeks
     *  d - days
     *  h - hours
     *  m - minutes
     *  s - seconds
     *
     * @param mixed $date 要比较的日期
     * @param string $elaps  比较跨度
     * @return integer
     */
    public function dateDiff($date, $elaps = "d") {
        $__DAYS_PER_WEEK__ = (7);
        $__DAYS_PER_MONTH__ = (30);
        $__DAYS_PER_YEAR__ = (365);
        $__HOURS_IN_A_DAY__ = (24);
        $__MINUTES_IN_A_DAY__ = (1440);
        $__SECONDS_IN_A_DAY__ = (86400);

        //计算天数差
        $__DAYSELAPS = abs($this->parse($date) - $this->timestamp) / $__SECONDS_IN_A_DAY__;
        switch ($elaps) {
            case "y"://转换成年
                $__DAYSELAPS = $__DAYSELAPS / $__DAYS_PER_YEAR__;
                break;
            case "M"://转换成月
                $__DAYSELAPS = $__DAYSELAPS / $__DAYS_PER_MONTH__;
                break;
            case "w"://转换成星期
                $__DAYSELAPS = $__DAYSELAPS / $__DAYS_PER_WEEK__;
                break;
            case "h"://转换成小时
                $__DAYSELAPS = $__DAYSELAPS * $__HOURS_IN_A_DAY__;
                break;
            case "m"://转换成分钟
                $__DAYSELAPS = $__DAYSELAPS * $__MINUTES_IN_A_DAY__;
                break;
            case "s"://转换成秒
                $__DAYSELAPS = $__DAYSELAPS * $__SECONDS_IN_A_DAY__;
                break;
        }
        return $__DAYSELAPS;
    }

    /**
     * 人性化的计算日期差
     * @param mixed $time 要比较的时间
     * @param mixed $precision 返回的精度 同上 $elaps 的选项
     * @return string
     */
    public function timeDiff($time, $precision = false) {
        if (!is_numeric($precision) && !is_bool($precision)) {
            $_diff = array('y' => '年', 'M' => '个月', 'd' => '天', 'w' => '周', 's' => '秒', 'h' => '小时', 'm' => '分钟');
            return ceil($this->dateDiff($time, $precision)) . $_diff[$precision] . '前';
        }

        $diff = abs($this->parse($time) - $this->timestamp);
        $chunks = array(array(31536000, '年'), array(2592000, '个月'), array(604800, '周'), array(86400, '天'), array(3600, '小时'), array(60, '分钟'), array(1, '秒'));

        $count = 0;
        $since = '';
        for ($i = 0; $i < count($chunks); $i++) {
            if ($diff >= $chunks[$i][0]) {
                $num = floor($diff / $chunks[$i][0]);
                $since .= sprintf('%d' . $chunks[$i][1], $num);
                $diff = (int) ($diff - $chunks[$i][0] * $num);
                $count++;
                if (!$precision || $count >= $precision) {
                    break;
                }
            }
        }

        return $since . '前';
    }

    /**
     * 本周的第一天
     */
    public function firstDayOfWeek() {
        $diff = $this->weekday;
        return new self(strtotime(" - {$diff} day"));
    }

    /**
     * 本月的第一天
     */
    public function firstDayOfMonth() {
        return (new self(mktime(0, 0, 0, $this->month, 1, $this->year)));
    }

    /**
     * 本年的第一天
     */
    public function firstDayOfYear() {
        return (new self(mktime(0, 0, 0, 1, 1, $this->year)));
    }

    /**
     * 本周的最后一天
     */
    public function lastDayOfWeek() {
        $diff = 6 - $this->weekday;
        return new self(strtotime(" + {$diff} day"));
    }

    /**
     * 本月的最后一天
     */
    public function lastDayOfMonth() {
        return (new self(mktime(0, 0, 0, $this->month + 1, 0, $this->year)));
    }

    /**
     * 计算年份的最后一天 返回Date对象
     */
    public function lastDayOfYear() {
        return (new self(mktime(0, 0, 0, 1, 0, $this->year + 1)));
    }

    /**
     * 取得指定间隔日期
     *
     *    yyyy - 年
     *    q    - 季度
     *    m    - 月
     *    y    - day of year
     *    d    - 日
     *    w    - 周
     *    ww   - week of year
     *    h    - 小时
     *    n    - 分钟
     *    s    - 秒
     * @param integer $number 间隔数目
     * @param string $interval  比较类型
     */
    public function dateAdd($number = 0, $interval = "d") {
        $hours = $this->hour;
        $minutes = $this->minute;
        $seconds = $this->second;
        $month = $this->month;
        $day = $this->day;
        $year = $this->year;

        switch ($interval) {
            case "yyyy":
                $year += $number;
                break;
            case "q":
                $month += ($number * 3);
                break;
            case "m":
                $month += $number;
                break;
            case "y":
            case "d":
            case "w":
                $day += $number;
                break;
            case "ww":
                $day += ($number * 7);
                break;
            case "h":
                $hours += $number;
                break;
            case "n":
                $minutes += $number;
                break;
            case "s":
                $seconds += $number;
                break;
        }

        return (new self(mktime($hours, $minutes, $seconds, $month, $day, $year)));
    }

    /**
     * 到下个月的今天的天数
     */
    public function maxDayOfMonth() {
        return $this->dateDiff($this->dateAdd(1, 'm')->format(), 'd');
    }

    public function __toString() {
        return $this->format();
    }

    /**
     * 日期数字转中文
     * 用于日和月、周
     * @param integer $number 日期数字
     */
    public function numberToCh($number) {
        $number = intval($number);
        $array = array('一', '二', '三', '四', '五', '六', '七', '八', '九', '十');
        $str = '';
        if ($number == 0) {
            $str .= "十";
        }
        if ($number < 10) {
            $str .= $array[$number - 1];
        } elseif ($number < 20) {
            $str .= "十" . $array[$number - 11];
        } elseif ($number < 30) {
            $str .= "二十" . $array[$number - 21];
        } else {
            $str .= "三十" . $array[$number - 31];
        }
        return $str;
    }

    /**
     * 年份数字转中文
     * @param integer $yearStr 年份数字
     * @param boolean $flag 是否显示公元
     */
    public function yearToCh($yearStr = '', $flag = false) {
        if (empty($yearStr)) {
            $yearStr = $this->year;
        }

        $array = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
        $str = $flag ? '公元' : '';
        for ($i = 0; $i < strlen($yearStr); $i++) {
            $str .= $array[substr($yearStr, $i, 1)];
        }

        return $str;
    }

    /**
     *  判断日期 所属 干支 生肖 星座
     *  type 参数：XZ 星座 GZ 干支 SX 生肖
     *  @param string $type  获取信息类型
     */
    public function magicInfo($type) {
        $result = '';
        $m = $this->month;
        $y = $this->year;
        $d = $this->day;

        switch ($type) {
            case 'XZ'://星座
                $XZDict = array('摩羯', '宝瓶', '双鱼', '白羊', '金牛', '双子', '巨蟹', '狮子', '处女', '天秤', '天蝎', '射手');
                $zone = array(1222, 122, 222, 321, 421, 522, 622, 722, 822, 922, 1022, 1122, 1222);
                if ((100 * $m + $d) >= $zone[0] || (100 * $m + $d) < $zone[1]) {
                    $i = 0;
                } else {
                    for ($i = 1; $i < 12; $i++) {
                        if ((100 * $m + $d) >= $zone[$i] && (100 * $m + $d) < $zone[$i + 1]) {
                            break;
                        }
                    }
                }
                $result = $XZDict[$i] . '座';
                break;

            case 'GZ'://干支
                $GZDict = array(
                    array('甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸'),
                    array('子', '丑', '寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥')
                );
                $i = $y - 1900 + 36;
                $result = $GZDict[0][$i % 10] . $GZDict[1][$i % 12];
                break;

            case 'SX'://生肖
                $SXDict = array('鼠', '牛', '虎', '兔', '龙', '蛇', '马', '羊', '猴', '鸡', '狗', '猪');
                $result = $SXDict[($y - 4) % 12];
                break;
        }

        return $result;
    }

}
