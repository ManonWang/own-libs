<?php

namespace Home\Controller;

use Home\Model\DictionaryModel;

class AnalyseBaseController extends BaseController {

    protected $scoreMap = array('level_1' => 0, 'level_2' => 500, 'level_3' => 200, 'level_4' => 100, 'level_5' => 30, 'level_6' => 10, 'level_7' => 0);

    public function initAnalyseStartTime($varKey, $tplKey) {
        $time = I($varKey);
        $time = empty($time) ? strtotime('first day of last month') : strtotime($time);
        $this->assign($tplKey, $time);
        return date("Y-m-d", $time);
    }

    public function initAnalyseEndTime($varKey, $tplKey) {
        $time = I($varKey);
        $time = empty($time) ? strtotime('last day of last month') : strtotime($time);
        $this->assign($tplKey, $time);
        return date("Y-m-d", $time);
    }

    public function getAnalyseStartTime() {
        return $this->initAnalyseStartTime('start_time', 'startTime');
    }

    public function getAnalyseEndTime() {
        return $this->initAnalyseEndTime('end_time', 'endTime');
    }

    public function getAnalyseType() {
        $type = I('type');
        $type = empty($type) ? 1 : $type;
        $this->assign('type', $type);
        return $type;
    }
    
    public function setDeptAndRiskLevel($model) {
        $allTypes = DictionaryModel::$types;
        $lists = $this->setDicData(array('department', 'risk_level'));

        $deptData = $model->hashByFeild($lists[$allTypes['department']], 'id');
        $this->assign('deptData', $deptData);

        $levelData = $model->hashByFeild($lists[$allTypes['risk_level']], 'user_key');
        $this->assign('levelData', $levelData);
    }

    public function setAnalyseSourceData($startTime, $endTime, $type) {
        $model = $this->getModel("Risk");
        $result = $model->getSourceData(array('start_time' => $startTime, 'end_time' => $endTime, 'type' => $type));
        $this->assign('data', $result);
        $this->setDeptAndRiskLevel($model);
    }

    public function setAnalyseDistributeData($startTime, $endTime, $type, $department = array()) {
        $model = $this->getModel("Risk");
        $result = $model->getDistributeData(array('start_time' => $startTime, 'end_time' => $endTime, 'type' => $type, 'department' => $department));
        $this->assign('data', $result);
        $this->assign('scoreMap', $this->scoreMap);
        $this->setDeptAndRiskLevel($model);
    }

    public function setAnalyseRegionData($startTime, $endTime, $type) {
        $model = $this->getModel("Risk");
        $result = $model->getStationData(array('start_time' => $startTime, 'end_time' => $endTime, 'type' => $type));
        $this->assign('data', $result);

        $allTypes = DictionaryModel::$types;
        $lists = $this->setDicData(array('station'));

        $stationData = $model->hashByFeild($lists[$allTypes['station']], 'id');
        $this->assign('stationData', $stationData);
    }

    public function setAnalyseTimeData($startTime, $endTime) {
        $model = $this->getModel("Risk");
        $result = $model->getTimeData(array('start_time' => $startTime, 'end_time' => $endTime));
        $this->assign('data', $result);

        $allTypes = DictionaryModel::$types;
        $lists = $this->setDicData(array('risk_level'));

        $levelData = $model->hashByFeild($lists[$allTypes['risk_level']], 'user_key');
        $this->assign('levelData', $levelData);
    }

    public function setAlarmList($data, $key = '') {
        $model = $this->getModel('Alarm');
        $allTypes = DictionaryModel::$types;

        $lists = $this->setDicData(array('department', 'alarm_type'));
        $dept = $model->hashByFeild($lists[$allTypes['department']], 'id');
        $type = $model->hashByFeild($lists[$allTypes['alarm_type']], 'id');
        $ktype = $model->hashByFeild($lists[$allTypes['alarm_type']], 'user_key');

        if (!empty($key)) {
            $data['type'] = $ktype[$key]['id'];
        }

        $result = $model->getAlarmList($data);
        foreach ($result['data_list'] as &$item) {
            $item['type_cn'] = $type[$item['type']]['name'];
            foreach (explode(',', $item['fix_dept']) as $deptId) {
                $item['fix_dept_cn'] .= ($dept[$deptId]['name'] . ' ');
            }
        }

        $this->assign('pagedList', $result);
        return $result;
    }

    public function setAlarmData() {
        $id = intval(I('id'));
        $model = $this->getModel('Alarm');

        if ($id > 0) {
            $result = $model->getOne(array('id' => $id, 'status' => 1));
            $result['fix_dept'] = explode(',', $result['fix_dept']);
            $this->assign('data', $result);
        }

        $allTypes = DictionaryModel::$types;
        $lists = $this->setDicData(array('department', 'alarm_type', 'alarm_source'));
        $this->assign('alarmType', $model->hashByFeild($lists[$allTypes['alarm_type']], 'user_key'));
    }

}
