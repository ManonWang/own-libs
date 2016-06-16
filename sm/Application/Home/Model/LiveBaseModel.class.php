<?php

namespace Home\Model;

class LiveBaseModel extends BaseModel {

    public function getConds($data) {
        $conds = array('status' => 1);
        if (!empty($data['start_time'])) {
            $conds['report_time'][] = array("egt", $data['start_time']);
        }
        if (!empty($data['end_time'])) {
            $conds['report_time'][] = array("elt", $data['end_time']);
        }
        if (!empty($data['type'])) {
            $conds['type'] = $data['type'];
        }
        if (!empty($data['model'])) {
            $conds['model'] = $data['model'];
        }
        if (!empty($data['number'])) {
            $conds['number'] = $data['number'];
        }
        return $conds;
    }

    public function getStatData($data) {
        $return = array();
        $conds = $this->getConds($data);

        $result = $this->field('model, COUNT(*) as num')->group('model')->getList($conds, 'num DESC');
        foreach($result as $item) {
            $return[$item['model']] = $item['num'];
        }

        return $return;
    }

    public function getAnalyseData($data) {
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

        $data = array('start_time' => (string) $startTime, 'end_time' => (string) $endTime);
        $conds = $this->getConds($data);

        $return = array();
        $result = $this->field('type, model, live_own, COUNT(*) as num')->group("type, model, live_own")->getList($conds, array('id DESC'));
        foreach ($result as $item) {
            $return[$item['type']][$item['model']][$item['live_own']] = $item['num'];
        }

        return $return;
    }

    public function queryJT($data, $type) {
        $conds = $this->getConds($data);
        if (!empty($data['keywords'])) {
            $column = 'Live6' == $type ? 'damage_palce' : 'live_item';
            $conds[$column] = array('LIKE', '%' . $data['keywords'] . '%');
        }
        return $this->getList($conds, 'id DESC');
    }

}

