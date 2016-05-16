<?php

namespace Home\Controller;

use Home\Model\DictionaryModel;

class RiskController extends BaseController {
    
    public function add() {
        $lists=$this->setDicData(array('department','risk_type','train','weather','risk_level','line','risk_cat1','risk_cat2','risk_cat3','risk_item'));
        $model = $this->getModel('RiskSummary');
        $this->assign('treeData', json_encode($model->getTreeData($lists)));
        $this->display();
    }
    
    public function insert() {
        $result = $this->model->saveRisk(I());
        if ($result) {
            return $this->ajaxReturn(0);
        }
    }

}
