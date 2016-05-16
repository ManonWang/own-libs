<?php

namespace Home\Controller;

use Home\Model\DictionaryModel;

class LineStopController extends BaseController {

    public function getList() {
        $lineId = intval(I('query'));
        $result = $lineId > 0 ? $this->model->getByLineId($lineId) : array();

        $allTypes = DictionaryModel::$types;
        $lists = $this->setDicData(array('station'));
        $stationData = $this->model->hashByFeild($lists[$allTypes['station']], 'id');

        foreach ($result as &$item) {
            $item['station_name'] = $stationData[$item['station_id']]['name'];
        }

        if ($result) {
            return $this->ajaxReturn(0, null, $result);
        }
    }

}
