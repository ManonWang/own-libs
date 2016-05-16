<?php

namespace Home\Controller;

use Home\Model\DictionaryModel;

class LocomotiveController extends BaseController {
    
    public function add() {
        $this->setDicData(array('live_type', 'locomotive_type'));
        $this->display();
    }

    public function insert() {
        $model = $this->getModel('LocomotiveReport');
        $result = $model->saveLocomotiveReport(I());
        if ($result) {
            return $this->ajaxReturn(0);
        }
    }
    
    public function live6() {
        $this->setDicData(array('live_own', 'live_type', 'locomotive_type'));
        $this->display();
    }
    
    public function insert6() {
        $model = $this->getModel('Live6');
        $result = $model->saveLive6(I());
        if ($result) {
            return $this->ajaxReturn(0);
        }
    }

    public function live28() {
        $this->setDicData(array('live_own', 'repair_process', 'team', 'live_type', 'locomotive_type'));
        $this->display();
    }

    public function insert28() {
        $model = $this->getModel('Live28');
        $result = $model->saveLive28(I());
        if ($result) {
            return $this->ajaxReturn(0);
        }
    }
    
    public function getEngineModel() {
        $model  = $this->getModel('Locomotive');
        $result = $model->getListByType(I('query'));
        if ($result) {
            return $this->ajaxReturn(0, null, $result); 
        }
    }
    
    public function getEngineNumber() {
        $model  = $this->getModel('Locomotive');
        $result = $model->getListByModel(I('query'));
        if ($result) {
            return $this->ajaxReturn(0, null, $result); 
        }
    }
    
}
