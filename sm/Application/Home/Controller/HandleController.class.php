<?php

namespace Home\Controller;

use Home\Model\DictionaryModel;

class HandleController extends AnalyseBaseController {

    private function getRiskList($data) {
        $this->setDicData(array('department', 'risk_type', 'risk_level', 'risk_item'));
        $model = $this->getModel('Risk');
        $result = $model->queryList($data);
        $this->assign('pagedList', $result);
        return $result;
    }

    public function aduit() {
        $data = array('page' => I('page'), 'audit_status' => 1);
        $this->getRiskList($data);
        $this->display();
    }

    public function aduitShow() {
        $id = I('id', 'int');
        if (empty($id)) {
            return ;
        }

        $lists=$this->setDicData(array('department','risk_type','train','weather','risk_level','line','risk_cat1','risk_cat2','risk_cat3','risk_item', 'station'));
        $model = $this->getModel('RiskSummary');
        $this->assign('treeData', json_encode($model->getTreeData($lists)));

        $model = $this->getModel('Risk');
        $data  = $model->getOne(array('status' => 1, 'id' => $id));
        $this->assign('data', $data);

        $workIds[] = $data['report_user_id'];
        $workIds[] = $data['resp_user_id'];

        $model = $this->getModel('Staff');
        $data  = $model->getStaffByWorkIds(array('work_ids' => $workIds));
        $data  = $model->hashByFeild($data, 'work_id');
        $this->assign('staff', $data);

        $this->display();
    }

    public function auditDeal() {
        $data = I();
        $model = $this->getModel('Risk');
        $row = $model->getOne(array('status' => 1, 'id' => intval($data['id'])));
        if (empty($row)) {
            return $this->ajaxReturn('1', '找不到数据');
        }

        $row = array_merge($row, $data);
        $action = trim($_REQUEST['act']);
        if ($action == 'delete') {
            $row['status'] = 2;
        } elseif ($action == 'audit') {
            $row['audit_status'] = 2;
            $row['audit_time'] = time();
        }

        if ($model->saveRisk($row)) {
            $this->ajaxReturn(0);
        }
    }

    public function deal() {
        $data = array('page' => I('page'), 'audit_status' => 1);
        $this->setAlarmList($data);
        $this->display();
    }

    public function dealShow() {
        $this->setAlarmData();
        $this->display();
    }

    public function auditResp() {
        $data = I();
        $model = $this->getModel('Alarm');
        $row = $model->getOne(array('status' => 1, 'id' => intval($data['id'])));
        if (empty($row)) {
            return $this->ajaxReturn('1', '找不到数据');
        }

        $row = array_merge($row, $data);
        $row['resp_status'] = 2;
        $row['resp_time'] = time();

        if ($model->saveOne($row)) {
            $this->ajaxReturn(0);
        }
    }

    public function select() {
        $time = time();
        $data = array(
            'page' => I('page'), 
            'audit_status' => 1,
            'is_stress' => 1,
        );
        $this->getRiskList($data);
        $this->assign('date', date('m月d日', $time));
        $this->display();
    }

    public function selectDeal() {
        $data = array();
        foreach (I() as $key => $val) {
            $data[$val][] = str_replace('stress_trace_', '', $key);
        }
        $model = $this->getModel('Risk');
        $result = $model->updateStressTrace($data);
        if ($result) {
            $this->ajaxReturn(0);
        }
    }

    public function track() {
        $lists = $this->setDicData(array('department', 'track_type'));
        $model = $this->getModel('Track');
        $result = $model->getList(array('status' => 1), 'id DESC');
        $this->assign('result', $result);
        $this->display();
    }

    public function trackShow() {
        $id = I('id');
        if (!empty($id)) {
            $model = $this->getModel('Track');
            $data  = $model->getOne(array('id' => $id));
            $this->assign('data', $data);
        }

        $lists = $this->setDicData(array('department', 'track_type'));
        $this->assign('track_time', date('Y-m-d H:i:s'));
        $this->display();
    }

    public function trackSave() {
        $id = I('id');
        $model = $this->getModel('Track');

        if (!empty($id)) {
            $data = $model->getOne(array('id' => $id));
            $data = array_merge($data, I());
        } else {
            $data = I();
        }

        $model = $this->getModel('Track');
        return $model->saveOne($data) ? $this->ajaxReturn(0) : $this->ajaxReturn(1, '保存失败');
    }

    public function trackDel() {
        $id = I('id');
        if (empty($id)) {
            return ;
        }

        $model = $this->getModel('Track');
        $row = $model->getOne(array('id' => $id));
        $row['status'] = 2;

        return $model->saveOne($row) ? $this->ajaxReturn(0) : $this->ajaxReturn(1, '删除失败');
    }

    public function uploadFile() {
        $urlPath = "/Public/upload/";
        $upload = new \Think\Upload();
        $upload->rootPath = '.' . $urlPath;
        $info = $upload->upload();
        if (!$info) {
            return $this->ajaxReturn(-1, '上传文件失败');
        }

        $ids = explode(",", I('ids'));
        $url = $urlPath . $info['filename']['savepath'] . $info['filename']['savename'];

        $model = $this->getModel('Track');
        $result = $model->where(array('id' => array('IN', $ids)))->setField(array('access_url' => $url, 'update_time' => time()));
        return $result ? $this->ajaxReturn(0) : $this->ajaxReturn(-1, '上传文件失败');
    }

    public function stat() {
        $startTime = $this->getAnalyseStartTime();
        $endTime = $this->getAnalyseEndTime();
        $trackDept = I('track_dept');
        $this->assign('track_dept', $trackDept);

        $lists = $this->setDicData(array('department', 'track_type'));
        $data  = array('start_time' => $startTime, 'end_time' => $endTime, 'status' => 1, 'track_dept' => $trackDept);
        $model = $this->getModel('Track');

        $data = $model->getTrackStat($data);
        $this->assign('pagedList', $data);

        $this->display();
    }

    public function fix() {
        $data = array('page' => I('page'), 'audit_status' => 1);
        $this->getRiskList($data);
        $this->display();
    }

    public function fixShow() {
        $id = I('id');
        $model = $this->getModel('Risk');
        $lists = $this->setDicData(array('department', 'track_type', 'risk_type', 'risk_item'));
        $data = $model->getOne(array('status' => 1, 'id' => $id));
        $this->assign('data', $data);
        $this->display();
    }

    public function fixDeal() {
        $id = I('id');
        $model = $this->getModel('Risk');  
        $data = $model->getOne(array('id' => $id));
        $data = array_merge($data, I());
        $data['deal_status'] = 2;
        return $model->saveOne($data) ? $this->ajaxReturn(0) : $this->ajaxReturn(-1, '操作失败');
    }

    public function destroy() {
        $data = array('page' => I('page'), 'audit_status' => 1);
        $this->getRiskList($data);
        $this->display();
    }

    public function destroyShow() {
        $id = I('id');
        $model = $this->getModel('Risk');
        $lists = $this->setDicData(array('department', 'track_type', 'risk_type', 'risk_item'));
        $data = $model->getOne(array('status' => 1, 'id' => $id));
        $this->assign('data', $data);

        $workIds[] = $data['report_user_id'];
        $workIds[] = $data['resp_user_id'];
        $workIds[] = $data['fix_user_id'];

        $model = $this->getModel('Staff');
        $data  = $model->getStaffByWorkIds(array('work_ids' => $workIds));
        $data  = $model->hashByFeild($data, 'work_id');
        $this->assign('staff', $data);

        $this->display();
    }

    public function destroyDeal() {
        $id = I('id');
        $model = $this->getModel('Risk');  
        $data = $model->getOne(array('id' => $id));
        $data = array_merge($data, I());
        return $model->saveOne($data) ? $this->ajaxReturn(0) : $this->ajaxReturn(-1, '操作失败');
    }

}
