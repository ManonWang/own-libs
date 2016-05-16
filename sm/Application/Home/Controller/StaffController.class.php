<?php

namespace Home\Controller;

use Home\Model\DictionaryModel;

class StaffController extends BaseController {

    public function suggest() {
        $keywords = trim(I('keywords'));

        $lists = array();
        if (!empty($keywords)) {
            $lists = $this->model->getByKeywords($keywords);
        }

        return $this->ajaxReturn(0, null, $lists);
    }

    public function department() {
        $workId = trim(I('query'));
        $data = $this->model->getByWorkId($workId);
        return $this->ajaxReturn(0, null, $data);
    }

}
