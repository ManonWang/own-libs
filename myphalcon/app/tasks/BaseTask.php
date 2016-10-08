<?php

namespace MyPhalcon\App\Tasks;

class BaseTask extends \Phalcon\CLI\Task {

    public function getTaskName() {
        return $this->dispatcher->getTaskName();
    }

    public function getFacade($facadeName = '') {
        if (empty($facadeName)) {
            $facadeName = $this->getTaskName();
        }

        $facadeName = 'MyPhalcon\App\Facade\\' . ucfirst($facadeName) . 'Facade';
        if (!class_exists($facadeName)) {
            throw new \Exception(get_lang('CLASS_NOT_FOUND', $facadeName));
        }

        return new $facadeName();
    }

}
