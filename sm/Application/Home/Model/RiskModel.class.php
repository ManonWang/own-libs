<?php

namespace Home\Model;

use Home\Model\StaffModel;

class RiskModel extends BaseModel {

    public function saveRisk($data) {
        if ($data['event_place_type'] == 2) {
            $data['event_place_station'] = 0;
            $data['event_place_line'] = $data['event_place_line_2'];
        } else {
            $data['event_place_start'] = 0;
            $data['event_place_end'] = 0;
            $data['event_place_line'] = $data['event_place_line_1'];
        }

        $eventDateTime = strtotime($data['event_date_time']);
        $data['event_time_year'] = date('Y', $eventDateTime);
        $data['event_time_month'] = date('m', $eventDateTime);
        $data['event_time_day'] = date('d', $eventDateTime);
        $data['event_time_hour'] = date('H', $eventDateTime);
        $data['event_time_min'] = date('i', $eventDateTime);
        $data['weather_type'] = implode(',', $data['weather_type']);

        return $this->saveOne($data);
    }

    private function getAnalyseConds($data) {
        $conds = array('status' => 1);
        if (!empty($data['start_time'])) {
            $conds['event_date_time'][] = array("egt", $data['start_time']);
        }
        if (!empty($data['end_time'])) {
            $conds['event_date_time'][] = array("elt", $data['end_time']);
        }
        if (!empty($data['menu_type'])) {
            $conds['menu_type'] = intval($data['menu_type']);
        }
        if (!empty($data['from_dept_id'])) {
            $conds['from_dept_id'] = intval($data['from_dept_id']);
        }
        if (!empty($data['resp_dept_id'])) {
            $conds['resp_dept_id'] = intval($data['resp_dept_id']);
        }
        if (!empty($data['resp_user_id'])) {
            $conds['resp_user_id'] = intval($data['resp_user_id']);
        }
        if (!empty($data['train_type'])) {
            $conds['train_type'] = intval($data['train_type']);
        }
        if (!empty($data['risk_level'])) {
            $conds['risk_level'] = intval($data['risk_level']);
        }
        if (!empty($data['event_time_year'])) {
            $conds['event_time_year'] = intval($data['event_time_year']);
        }
        if (!empty($data['audit_status'])) {
            $conds['audit_status'] = intval($data['audit_status']);
        }
        if (!empty($data['is_stress'])) {
            $conds['is_stress'] = intval($data['is_stress']);
        }
        if (!empty($data['weather_type'])) {
            $conds['_string'] = "FIND_IN_SET(" . intval($data['weather_type']) . ", weather_type)";
        }
        return $conds;
    }

    public function getSourceData($data) {
        $return = array();
        $conds = $this->getAnalyseConds($data);

        if ($data['type'] == 1) {
            $result = $this->field("menu_type, risk_level, COUNT(*) as num, menu_cat")->group('menu_type, risk_level')->getList($conds);
            foreach ($result as $item) {
                $return[$item['menu_cat']][$item['menu_type']][$item['risk_level']]++;
            }
        } else {
            $result = $this->field("from_dept_id, risk_level, COUNT(*) as num")->group('from_dept_id, risk_level')->getList($conds, 'num DESC');
            foreach ($result as $item) {
                $return[$item['from_dept_id']][$item['risk_level']] = $item['num'];
            }
        }

        return $return;
    }

    public function getDistributeData($data) {
        $return = array();
        $conds = $this->getAnalyseConds($data);

        if (in_array($data['type'], array(1, 2))) {
            $result = $this->field("resp_dept_id, risk_level, COUNT(*) as num")->group('resp_dept_id, risk_level')->getList($conds, 'num DESC');
            foreach ($result as $item) {
                $return[$item['resp_dept_id']][$item['risk_level']] = $item['num'];
            }
        } elseif (3 == $data['type']) {
            if (is_array($data['department']) && count($data['department'])) {
                $conds['resp_dept_id'] = array('IN', $data['department']);
            }

            $conds['_string'] = 'from_dept_id = resp_dept_id';
            $result = $this->field("resp_dept_id, COUNT(*) as num")->group('resp_dept_id')->getList($conds, 'num DESC');
            foreach ($result as $item) {
                $return['self_found'][$item['resp_dept_id']] = $item['num'];
                $return['risk_dept'][$item['resp_dept_id']] = 1;
            }

            $conds['_string'] = 'from_dept_id != resp_dept_id';
            $result = $this->field("resp_dept_id, COUNT(*) as num")->group('resp_dept_id')->getList($conds, 'num DESC');
            foreach ($result as $item) {
                $return['other_found'][$item['resp_dept_id']] = $item['num'];
                $return['risk_dept'][$item['resp_dept_id']] = 1;
            }

            $staffModel = new StaffModel();
            $staffCount = $staffModel->getDeptStaffCount();
            foreach ($staffCount as $item) {
                $return['staff_count'][$item['depart_id']] = $item['num'];
            }
        } elseif (4 == $data['type']) {
            $result = $this->field("resp_dept_id, risk_level, COUNT(*) as num")->group('resp_dept_id, risk_level')->getList($conds, 'num DESC');
            foreach ($result as $item) {
                $return['risk_data'][$item['resp_dept_id']][$item['risk_level']] = $item['num'];
            }

            $staffModel = new StaffModel();
            $staffCount = $staffModel->getDeptStaffCount();
            foreach ($staffCount as $item) {
                $return['staff_count'][$item['depart_id']] = $item['num'];
            }
        }

        return $return;
    }

    public function getStationData($data) {
        $return = array();
        $conds = $this->getAnalyseConds($data);

        if (1 == $data['type']) {
            $conds['event_place_type'] = 1;
            $result = $this->field('event_place_station, COUNT(*) as num')->group('event_place_station')->getList($conds, 'num DESC');
            foreach ($result as $item) {
                $return[$item['event_place_station']] = $item['num'];
            }
        } else {
            $conds['event_place_type'] = 2;
            $result = $this->field('event_place_start, event_place_end')->getList($conds);
            foreach ($result as $item) {
                $start = $item['event_place_start'];
                $ended = $item['event_place_end'];
                $key = $start <= $ended ? $start . '_' . $ended : $ended . '_' . $start;
                $return[$key]['count']++;
                $return[$key]['start'] = $start;
                $return[$key]['end'] = $ended;
            }

            $count = array();
            foreach ($result as $key => $item) {
                $count[$key] = $item['count'];
            }
            array_multisort($count, SORT_DESC, $return);
        }

        return $return;
    }

    public function getWeatherData($data) {
        $conds = $this->getAnalyseConds($data);
        return $this->field('risk_level, risk_outline_id, COUNT(*) AS num')->group('risk_level, risk_outline_id')->getList($conds, 'num DESC');
    }

    public function getTimeData($data) {
        $return = array();
        $conds = $this->getAnalyseConds($data);

        $result = $this->field('event_time_hour, risk_level, COUNT(*) as num')->group('event_time_hour, risk_level')->getList($conds, 'num DESC');
        foreach ($result as $item) {
            $return[$item['event_time_hour']][$item['risk_level']] = $item['num'];
        }

        return $return;
    }

    public function getConstituteData($data) {
        $return = array();
        $conds = $this->getAnalyseConds($data);

        $result = $this->field('risk_outline_id, COUNT(*) as num')->group('risk_outline_id')->getList($conds, 'num DESC');
        foreach ($result as $item) {
            $return[$item['risk_outline_id']] = $item['num'];
        }

        $count = 1;
        foreach ($return as $riskOutlineId => $num) {
            if ($count ++ > 9) {
                $total += $num;
                unset($return[$riskOutlineId]);
            }
        }

        $return['other'] = $total;
        return $return;
    }

    public function getStageData($data) {
        $stage1 = $this->queryStage($data, 'start_time_1', 'end_time_1');
        $dateDiff1 = intval((strtotime($data['end_time_1']) - strtotime($data['start_time_1'])) / 86400) + 1;

        $stage2 = $this->queryStage($data, 'start_time_2', 'end_time_2');
        $dateDiff2 = intval((strtotime($data['end_time_2']) - strtotime($data['start_time_2'])) / 86400) + 1;

        return array('stage1' => $stage1, 'diff1' => $dateDiff1, 'stage2' => $stage2, 'diff2' => $dateDiff2);
    }

    public function queryStage($data, $startTimeKey, $endTimeKey) {
        $data['start_time'] = $data[$startTimeKey];
        $data['end_time'] = $data[$endTimeKey];

        $conds = $this->getAnalyseConds($data);
        return $this->field('risk_outline_id, COUNT(*) as num')->group('risk_outline_id')->limit(10)->getList($conds, 'num DESC');
    }

    public function queryList($data) {
        if (!empty($data['source'])) {
            $data['menu_type'] = intval($data['source']);
        }

        $conds = $this->getAnalyseConds($data);
        return $this->where($conds)->getPagedList($conds, 'id DESC', intval($data['page']));
    }

    public function queryDeptDataByYear($data) {
        $return = array();
        $conds = $this->getAnalyseConds($data);

        $result = $this->field('resp_dept_id, risk_level, COUNT(*) as num')->group('resp_dept_id, risk_level')->getList($conds, 'num DESC');
        foreach($result as $item) {
            $return[$item['resp_dept_id']][$item['risk_level']] = $item['num'];
        }

        return $return;
    }

    public function updateStressTrace($data) {
        foreach ($data as $val => $ids) {
            $conds['id'] = array('IN', $ids);
            if (!$this->where($conds)->setField(array('stress_trace' => $val, 'update_time' => time()))) {
                return false;
            }
        }
        return true;
    }

    public function getTrendData($data) {
        $conds = $this->getAnalyseConds($data);
        return $this->field('event_time_month, resp_dept_id, risk_level')->getList($conds, 'event_date_time ASC');
    }

    public function getScoreData($data) {
        if (empty($data['timeYear'])) {
            $data['timeYear'] = date('Y');
        }

        if (!empty($data['timeMonth'])) {
            $datetime = strtotime($data['timeYear'] . '-' .  sprintf('%02d', $data['timeMonth']) . '-01');
            $startTime = date('Y-m', $datetime);
            $endTime = date('Y-m', strtotime('+1 month', $datetime));
        } else {
            $startTime = intval($data['timeYear']);
            $endTime = $startTime + 1;
        }

        $data['start_time'] = (string) $startTime;
        $data['end_time']   = (string) $endTime;
        $conds = $this->getAnalyseConds($data);

        $return = array();
        $result = $this->field('resp_user_id, risk_level, COUNT(*) as num')->group('resp_user_id, risk_level')->getList($conds);
        foreach ($result as $item) {
             $return[$item['resp_user_id']][$item['risk_level']] = $item['num'];
        }
        return $return;
    }

}
