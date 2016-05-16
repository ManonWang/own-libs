<?php 

namespace Home\Model;

class LineStopModel extends BaseModel {
    
    public function getByLineId($lineId) {
        $conds = array('line_id' => $lineId, 'status' => 1);
        return $this->getList($conds, array('position' => 'ASC'));
    }

    public function getByIds($ids) {
        $conds = array('id' => array('IN', $ids), 'status' => 1);
        return $this->getList($conds);
    }

}

