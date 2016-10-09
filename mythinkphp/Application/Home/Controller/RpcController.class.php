<?php

namespace Home\Controller;

use Think\Controller\HproseController;
use Common\Library\LoggerUtil;

class RpcController extends HproseController {

    protected $crossDomain = true;
    protected $P3P         = true;
    protected $allowMethodList = array('run');

    public function run($rpcArgs) {
        try {
            LoggerUtil::info('RPC CALL: ' . json_encode($rpcArgs, JSON_UNESCAPED_UNICODE));

            $serviceName = $rpcArgs['service'];
            $service = $this->getService($serviceName);

            $methodName = $rpcArgs['method'];
            if (!method_exists($service, $methodName)) {
                throw new \Exception(get_lang('METHOD_NOT_FOUND', $methodName));
            }

            $result = call_user_func_array(array($service, $methodName), $rpcArgs['params']);
            LoggerUtil::info('RPC SUCC: ' . json_encode($result, JSON_UNESCAPED_UNICODE));

            return $result;
        } catch (\Exception $e) {
            LoggerUtil::error('RPC FAIL: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getService($serviceName) {
        $serviceName = MODULE_NAME . '\\Service\\' . ucfirst($serviceName) . 'Service';
        if (!class_exists($serviceName)) {
            throw new \Exception(get_lang('CLASS_NOT_FOUND', $serviceName));
        }

        return new $serviceName();
    }

}
