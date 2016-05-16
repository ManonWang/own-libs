<?php 

namespace Home\Model;

class StaffModel extends BaseModel {

    public function getByKeywords($keywords) {
        $conds = array('salary_id|work_id|name' => array('LIKE', "%{$keywords}%"), 'status' => 1);
        $lists = $this->getList($conds, null, 300);

        $data  = array();
        foreach ($lists as $item) {
            $data[] = array('work_id' => $item['work_id'], 'name' => $item['name'], 'salary_id' => $item['salary_id']);
        }

        return $data;
    }

    public function getByWorkId($workId) {
        $conds = array('work_id' => $workId, 'status' => 1);
        return $this->getOne($conds);
    }

    public function getDeptStaffCount() {
        return $this->field('depart_id, COUNT(*) as num')->group('depart_id')->select();
    }

    public function getStaffByWorkIds($data) {
        $conds = array("status" => 1);
        if (!empty($data['work_ids'])) {
            $conds['work_id'] = array('IN', $data['work_ids']);
        }
        return $this->getList($conds);
    }

}

