<?php

namespace Home\Controller;

use Home\Model\DictionaryModel;

class AnalyseController extends AnalyseBaseController {

    public function supervise() {
        $data = array('page' => I('page'));
        $this->setAlarmList($data, 'supervise');
        $this->display();
    }

    public function superviseAdd() {
        $this->setAlarmData();
        $this->display();
    }

    public function superviseInsert() {
        $model = $this->getModel('Alarm');
        $result = $model->saveAlarm(I());
        if ($result) {
            return $this->ajaxReturn(0);
        }
    }

    public function chgFixStatus() {
        $id = intval(I('id'));
        if ($id <= 0) {
            return $this->ajaxReturn(1, '错误的参数');
        }

        $model = $this->getModel('Alarm');
        $result = $model->getOne(array('id' => $id, 'status' => 1));
        if (!empty($result)) {
            $result['fix_status'] = 2;
            $result = $model->saveAlarm($result);
        }

        return $result ? $this->ajaxReturn(0) : $this->ajaxReturn(0, '落实操作失败');
    }

    //来源
    public function source() {
        $startTime = $this->getAnalyseStartTime();
        $endTime = $this->getAnalyseEndTime();
        $type = $this->getAnalyseType();

        $this->setAnalyseSourceData($startTime, $endTime, $type);
        $this->assign('source', 1 == $type ? '平台' : '部门');

        $this->display(ACTION_NAME . '_' . $type);
    }

    //分布分析
    public function distribute() {
        $startTime = $this->getAnalyseStartTime();
        $endTime = $this->getAnalyseEndTime();
        $type = $this->getAnalyseType();

        $respDeptId = I('resp_dept_id');
        $this->assign('resp_dept_id', $respDeptId);

        $type = $type < 1 || $type > 4 ? 1 : $type;
        $typeText = array(
            '1' => '绝对数量分布分析',
            '2' => '绝对占比分布分析',
            '3' => '相对数量分布分析',
            '4' => '相对分值分布分析',
        );

        $this->setAnalyseDistributeData($startTime, $endTime, $type, $respDeptId);
        $this->assign('source', $typeText[$type]);
        $this->assign('types', $typeText);

        $this->display(ACTION_NAME . '_' . $type);
    }

    //地域
    public function region() {
        $startTime = $this->getAnalyseStartTime();
        $endTime = $this->getAnalyseEndTime();
        $type = $this->getAnalyseType();

        $type = $type < 1 || $type > 2 ? 1 : $type;
        $typeText = array('1' => '站场分析', '2' => '区间分析');

        $this->setAnalyseRegionData($startTime, $endTime, $type);
        $this->assign('source', $typeText[$type]);
        $this->assign('types', $typeText);

        $this->display(ACTION_NAME . '_' . $type);
    }

    //天气
    public function weather() {
        $startTime = $this->getAnalyseStartTime();
        $endTime = $this->getAnalyseEndTime();

        $weatherType = I('weather_type');
        $this->assign('weatherType', $weatherType);

        $model = $this->getModel("Risk");
        $this->setDicData(array('weather', 'risk_level', 'risk_item'));
        $data = $model->getWeatherData(array('start_time' => $startTime, 'end_time' => $endTime, 'weather_type' => intval($weatherType)));
        $this->assign('data', $data);

        $this->display();
    }

    //时间
    public function time() {
        $startTime = $this->getAnalyseStartTime();
        $endTime = $this->getAnalyseEndTime();
        $type = $this->getAnalyseType();

        $type = $type < 1 || $type > 2 ? 1 : $type;
        $typeText = array('1' => '分析表', '2' => '分析图');

        $this->setAnalyseTimeData($startTime, $endTime, $type);
        $this->assign('source', $typeText[$type]);
        $this->assign('types', $typeText);

        $this->display(ACTION_NAME . '_' . $type);
    }

    //构成
    public function constitute() {
        $startTime = $this->getAnalyseStartTime();
        $endTime = $this->getAnalyseEndTime();

        $respDeptId = I('resp_dept_id');
        $this->assign('respDeptId', $respDeptId);

        $model = $this->getModel("Risk");
        $this->setDicData(array('department', 'risk_item'));
        $data = $model->getConstituteData(array('start_time' => $startTime, 'end_time' => $endTime, 'resp_dept_id' => $respDeptId));
        $this->assign('data', $data);

        $this->display();
    }

    //阶段
    public function stage() {
        $startTime1 = $this->initAnalyseStartTime('start_time_1', 'startTime1');
        $endTime1 = $this->initAnalyseEndTime('end_time_1', 'endTime1');

        $startTime2 = $this->initAnalyseStartTime('start_time_2', 'startTime2');
        $endTime2 = $this->initAnalyseEndTime('end_time_2', 'endTime2');

        $respDeptId = I('resp_dept_id');
        $this->assign('resp_dept_id', $respDeptId);

        $riskOutlineId = I('risk_outline_id');
        $this->assign('risk_outline_id', $riskOutlineId);

        $lists = $this->setDicData(array('department', 'risk_type', 'train', 'weather', 'risk_level', 'line', 'risk_cat1', 'risk_cat2', 'risk_cat3', 'risk_item'));
        $model = $this->getModel('RiskSummary');
        $this->assign('treeData', json_encode($model->getTreeData($lists)));

        $model = $this->getModel("Risk");
        $data = $model->getStageData(array(
            'start_time_1' => $startTime1,
            'end_time_1' => $endTime1,
            'start_time_2' => $startTime2,
            'end_time_2' => $endTime2,
            'resp_dept_id' => $respDeptId,
            'risk_outline_id' => $riskOutlineId,
        ));

        $data['stage1'] = $model->hashByFeild($data['stage1'], 'risk_outline_id');
        $data['stage2'] = $model->hashByFeild($data['stage2'], 'risk_outline_id');
        $data['stage'] = array_unique(array_merge(array_keys($data['stage1']), array_keys($data['stage2'])));
        $this->assign('data', $data);

        $this->display();
    }

    //组合
    public function combine() {
        foreach (I() as $key => $val) {
            $this->assign($key, $val);
        }

        $lists = $this->setDicData(array('department', 'train', 'weather', 'risk_level', 'risk_item'));
        $model = $this->getModel("Risk");

        $data = $model->queryList(I());
        $this->assign('pagedList', $data);

        $this->display();
    }

    //职工预警
    public function staff() {
        $eventTimeYear = I('event_time_year');
        if (empty($eventTimeYear)) {
            $eventTimeYear = date("Y", strtotime('last year'));
        }

        $model = $this->getModel('Risk');
        $data = $model->queryDeptDataByYear(array('event_time_year' => $eventTimeYear));
        $this->assign('data', $data);
        $this->assign('event_time_year', $eventTimeYear);
        $this->setDeptAndRiskLevel($model);

        $this->display();
    }

    public function audit() {
        $data = array('page' => I('page'), 'audit_status' => 1);
        $this->setAlarmList($data);
        $this->display();
    }

    public function auditShow() {
        $this->setAlarmData();
        $this->display();
    }

    public function auditDeal() {
        $data = I();
        $model = $this->getModel('Alarm');
        $row = $model->getOne(array('status' => 1, 'id' => intval($data['id'])));
        if (empty($row)) {
            return $this->ajaxReturn('1', '找不到数据');
        }

        $data['fix_dept'] = implode(',', array_unique($data['fix_dept']));
        $row = array_merge($row, $data);

        $action = trim($_REQUEST['act']);
        if ($action == 'delete') {
            $row['status'] = 2;
        } elseif ($action == 'audit') {
            $row['audit_status'] = 2;
        }

        if ($model->saveOne($row)) {
            $this->ajaxReturn(0);
        }
    }

    public function query() {
        $startTime = $this->getAnalyseStartTime();
        $endTime = $this->getAnalyseEndTime();

        $data = I();
        $data['audit_status'] = 2;
        $lists = $this->setDicData(array('department', 'alarm_type'));

        $this->setAlarmList($data);
        $this->assign('type', I('type'));
        $this->assign('fix_dept', I('fix_dept'));

        $this->display();
    }

    public function stat() {
        $startTime = $this->getAnalyseStartTime();
        $endTime = $this->getAnalyseEndTime();

        $model = $this->getModel('Alarm');
        $data  = $model->getStatData(array('start_time' => $startTime, 'end_time' => $endTime));
        $this->assign('data', $data);

        $allTypes = DictionaryModel::$types;
        $lists = $this->setDicData(array('department', 'alarm_type'));

        $typeData = $model->hashByFeild($lists[$allTypes['alarm_type']], 'user_key');
        $this->assign('typeData', $typeData);

        $this->display();
    }
    
    public function engine() {
        $startTime = date("Y-m-d", strtotime('first day of this month'));
        $endTime = date("Y-m-d");

        $types = array();
        $data = array('start_time' => $startTime, 'end_time' => $endTime);

        $model = $this->getModel('Live6');
        $lists = $model->getStatData($data);
        $this->assign('live6', $lists);
        foreach($lists as $key => $val) {
            $types[$key] = 1;
        }

        $model = $this->getModel('Live28');
        $lists = $model->getStatData($data);
        $this->assign('live28', $lists);
        foreach($lists as $key => $val) {
            $types[$key] = 1;
        }

        $this->assign('types', $types);
        $this->display();
    }

    private function analyseJT($name) {
        $timeYear = I('timeYear');
        $this->assign('timeYear', $timeYear);

        $timeMonth =  I('timeMonth');
        $this->assign('timeMonth', $timeMonth);

        $model = $this->getModel($name);
        $data = array('timeYear' => $timeYear, 'timeMonth' => $timeMonth);
        $result = $model->getAnalyseData($data);
        $this->assign('data', $result);

        $allTypes = DictionaryModel::$types;
        $lists = $this->setDicData(array('live_own', 'repair_process', 'team', 'live_type', 'locomotive_type'));

        $typeData = $model->hashByFeild($lists[$allTypes['locomotive_type']], 'user_key');
        $this->assign('typeData', $typeData);
    }

    public function analyseJT6() {
        $this->analyseJT('Live6');
        $this->display();
    }

    public function analyseJT28() {
        $this->analyseJT('Live28');
        $this->display();
    }

    public function queryJT($name) {
        foreach (I() as $key => $val) {
            $this->assign($key, $val);
        }

        $data = I();
        $this->setDicData(array('live_type', 'locomotive_type', 'live_own', 'repair_process'));

        $model = $this->getModel($name);
        $result = $model->queryJT($data, $name);
        $this->assign('data', $result);

        if ('Live6' == $name) {
            foreach($result as $item) {
                $workIds[] = $item['repair_user_id'];
            }

            $model = $this->getModel('Staff');
            $data  = $model->getStaffByWorkIds(array('work_ids' => $workIds));
            $data  = $model->hashByFeild($data, 'work_id');
            $this->assign('staff', $data);
        }

        return $result;
    }

    public function queryJT6() {
        $this->queryJT('Live6');
        $this->display();
    }

    public function queryJT28() {
        $this->queryJT('Live28');
        $this->display();
    }

    public function queryEngineAll() {
        $result = $this->queryJT('Live28');
        $this->assign('live28', $result);

        $result = $this->queryJT('Live6');
        $this->assign('live6', $result);

        $this->display();
    }

    public function trend() {
        $deptIds = I('resp_dept_id');
        $this->assign('resp_dept_id', $deptIds);

        $time = strtotime(date('Y-m-00'));
        $data['start_time'] = date('Y-m-d H:i:s', strtotime('-12 month, +1 day', $time));
        $data['end_time'] = date('Y-m-d H:i:s', $time);

        $model = $this->getModel('Risk');
        $result = $model->getTrendData($data);
        $dicData = $this->setDeptAndRiskLevel($model);

        $levelData = $dicData['levelData'];
        $needLevel = array($levelData['level_2']['id'], $levelData['level_3']['id'], $levelData['level_4']['id']);

        $allResult  = array();
        $deptResult = array();
        foreach ($result as $item) {
            $month = $item['event_time_month'];
            $dept  = $item['resp_dept_id'];

            $allResult[$month]['all_level'] ++;
            if (in_array($item['risk_level'], $needLevel)) {
                $allResult[$month]['need_level'] ++ ;
            }

            if (!empty($deptIds) && in_array($dept, $deptIds)) {
                $deptResult[$dept][$month]['all_level'] ++;
                if (in_array($item['risk_level'], $needLevel)) {
                    $deptResult[$dept][$month]['need_level'] ++;
                }
            }
        }

        $this->assign('startMonth', (int) date('m', strtotime($data['start_time'])));
        $this->assign('allResult', $allResult);
        $this->assign('deptResult', $deptResult);

        $this->display();
    }

    public function score() {
        $data = I();
        foreach ($data as $key => $val) {
            $this->assign($key, $val);
        }

        $allTypes = DictionaryModel::$types;
        $dicData = $this->setDicData(array('department', 'risk_level', 'work_type', 'position_name'));
        $levelData = $dicData[$allTypes['risk_level']];

        $scores = array();
        $model  = $this->getModel('Risk');
        $result = $model->getScoreData($data);
        foreach ($result as $workId => $workData) {
            foreach ($workData as $levelId => $levelCount) {
                $scores[$workId] += ($this->scoreMap[$levelData[$levelId]['user_key']] * $levelCount);
            }
        }

        $workIds = array_keys($result);
        if (!empty($data['resp_user_id'])) {
            $workIds[] = $data['resp_user_id'];
        }

        if (!empty($workIds)) {
            $model = $this->getModel('Staff');
            $data  = $model->getStaffByWorkIds(array('work_ids' => $workIds));
            $data  = $model->hashByFeild($data, 'work_id');
            $this->assign('staff', $data);
        }

        $this->assign('type', intval(I('timeMonth')) > 0);
        $this->assign('score', $scores);
        $this->display();
    }

}
