<?php 

namespace Home\Model;

class LocomotiveModel extends BaseModel {

    public function getListByType($type) {
        return $this->distinct('model')->where(array('type' => $type, 'status' => 1))->select();
    }

    public function getListByModel($model) {
        $conds = array('model' => $model, 'status' => 1);
        return $this->getList($conds);
    }

}

