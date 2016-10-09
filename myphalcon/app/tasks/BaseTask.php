<?php

namespace MyPhalcon\App\Tasks;

class BaseTask extends \Phalcon\CLI\Task {

    public function getTaskName() {
        return $this->dispatcher->getTaskName();
    }

    public function getService($serviceName = '') {
        if (empty($serviceName)) {
            $serviceName = $this->getTaskName();
        }

        $serviceName = 'MyPhalcon\App\Service\\' . ucfirst($serviceName) . 'Service';
        if (!class_exists($serviceName)) {
            throw new \Exception(get_lang('CLASS_NOT_FOUND', $serviceName));
        }

        return new $serviceName();
    }

}
