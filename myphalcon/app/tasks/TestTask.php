<?php

namespace MyPhalcon\App\Tasks;

class TestTask extends BaseTask {

    public function testAction($args = array()) {
        $service = $this->getService('user');
        $result = $service->getRowById('25');
        p($result);
    }

}
