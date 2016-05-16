<?php 

namespace Home\Model;

class LocomotiveReportModel extends BaseModel {
    
    public function saveLocomotiveReport($data) {
        $data['create_time'] = $data['update_time'] = time();
        return $this->saveOne($data);
    }

}

