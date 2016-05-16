<?php 

namespace Home\Model;

class Live28Model extends LiveBaseModel {
    
    public function saveLive28($data) {
        $data['create_time'] = $data['update_time'] = time();
        return $this->saveOne($data);
    }

}

