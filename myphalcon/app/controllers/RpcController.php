<?php

namespace MyPhalcon\App\Controllers;

use MyPhalcon\App\Library\LoggerUtil;

class RpcController extends \Phalcon\Mvc\Controller {

    protected $debug            =   false;
    protected $crossDomain      =   true;
    protected $P3P              =   true;
    protected $get              =   true;

    public function indexAction() {
        require VENDOR_PATH . '/Hprose/Hprose.php';

        $server  = new \Hprose\Http\Server();
        $server->addMethods(array('run'), $this);

        if($this->debug) {
            $server->setDebugEnabled(true);
        }

        $server->setCrossDomainEnabled($this->crossDomain);
        $server->setP3PEnabled($this->P3P);
        $server->setGetEnabled($this->get);

        $server->start();
    }

    public function getService($serviceName) {
        $serviceName = 'MyPhalcon\App\Service\\' . ucfirst($serviceName) . 'Service';
        if (!class_exists($serviceName)) {
            throw new \Exception(get_lang('CLASS_NOT_FOUND', $serviceName));
        }

        return new $serviceName();
    }

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

}
