<?php

namespace MyPhalcon\App\Tasks;

class TestTask extends BaseTask {

    public function testAction($args = array()) {
        $facade = $this->getFacade('user');
        $result = $facade->getRowById('25');
        p($result);
    }

}
