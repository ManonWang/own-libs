<?php 

namespace Home\Model;

class DictionaryModel extends BaseModel {
    
    /*type 字段类型和值*/
    public static $types = array(
        'work_flag'   => 1, //干部工人标识
        'work_time'   => 2, //劳动班制
        'work_type'   => 3, //工种
        'political'   => 4, //政治面貌
        'position_level'   => 5, //职位级别
        'position_name'    => 6, //职务名称
        'department'       => 7, //部门名称
        'team'  => 8,  //班组名称
        'line'  => 9,  //线路名称
        'train' => 10, //列车类别
        'weather'    => 11, //天气情况
        'risk_level' => 12, //风险等级
        'station'    => 13, //场信息
        'live_own'   => 14, //活项归属
        'repair_process'  => 15, //修程
        'locomotive_type' => 16, //机车类型
        'live_type'    => 17, //机车活项
        'alarm_source' => 18, //预警来源
        'alarm_type'   => 19, //预警类型
        'risk_type' => 20, //风险类别
        'risk_cat1' => 21, //风险概述-分类1
        'risk_cat2' => 22, //风险概述-分类2
        'risk_cat3' => 23, //风险概述-分类3
        'risk_item' => 24, //风险概述-内容
        'track_type'=> 25, //追踪类别
    );

    public function getListByType(array $types) {
        $conds = array('type' => array('IN', $types), 'status' => 1);
        $list  = $this->getList($conds);

        $data  = array();
        foreach ($list as $item) {
            $data[$item['type']][$item['id']] = $item;
        }

        return $data;
    }

}

