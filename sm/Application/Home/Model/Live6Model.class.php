<?php 

namespace Home\Model;

class Live6Model extends LiveBaseModel {
    
    public function saveLive6($data) {
        $data['create_time'] = $data['update_time'] = time();
        return $this->saveOne($data);
    }

}

