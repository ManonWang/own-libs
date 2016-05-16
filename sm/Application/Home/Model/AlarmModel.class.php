<?php 

namespace Home\Model;

class AlarmModel extends BaseModel {

    public function saveAlarm($data) {
        if (!$data['id']) {
            $data['fix_dept'] = implode(',', $data['fix_dept']);
        }

        $time = time();
        $data['update_time'] = $time;
        if (empty($data['create_time'])) {
            $data['create_time'] = $time;
        }

        return $this->saveOne($data);
    }

    public function getAlarmList($data) {
        $conds = array('status' => 1);
        if (!empty($data['type'])) {
            $conds['type'] = intval($data['type']);
        }
        if (!empty($data['audit_status'])) {
            $conds['audit_status'] = intval($data['audit_status']);
        }
        if (!empty($data['start_time'])) {
            $conds['alarm_time'][] = array("egt", $data['start_time']);
        }
        if (!empty($data['end_time'])) {
            $conds['alarm_time'][] = array("elt", $data['end_time']);
        }
        if (!empty($data['fix_dept'])) {
            $conds['_string'] = "FIND_IN_SET(" . intval($data['fix_dept']) . ", fix_dept)";
        }
        $order = array('id' => 'DESC');
        return $this->getPagedList($conds, $order, intval($data['page']));
    }

    public function getStatData($data) {
        $conds = array('status' => 1);
        if (!empty($data['start_time'])) {
            $conds['alarm_time'][] = array("egt", $data['start_time']);
        }
        if (!empty($data['end_time'])) {
            $conds['alarm_time'][] = array("elt", $data['end_time']);
        }

        $return = array();
        $lists = $this->getList($conds);
        foreach ($lists as $item) {
            $fixDept = array_unique(explode(',', $item['fix_dept']));
            foreach ($fixDept as $dept) {
                $return[$dept][$item['type']] ++ ;
            }
        }

        return $return;
    }

}
