<?php

namespace MyPhalcon\App\Controllers;

use MyPhalcon\App\Library\LoggerUtil;

class RpcController extends BaseController {

    protected $debug            =   false;
    protected $crossDomain      =   true;
    protected $P3P              =   true;
    protected $get              =   true;

    public function indexAction() {
        require VENDOR_PATH . '/Hprose/Hprose.php';

        $server  = new \Hprose\Http\Server();
        $server->addMissingMethod('run', $this);

        if($this->debug) {
            $server->setDebugEnabled(true);
        }

        $server->setCrossDomainEnabled($this->crossDomain);
        $server->setP3PEnabled($this->P3P);
        $server->setGetEnabled($this->get);

        $server->start();
    }

    public function run($name, $args) {
        $lastSeparator = strrpos($name, '_');
        $rpcArgs = array(
            'service' => substr($name, 0, $lastSeparator),
            'method'  => substr($name, $lastSeparator + 1),
            'params'  => $args,
        );

        try {
            LoggerUtil::info('RPC CALL: ' . json_encode($rpcArgs, JSON_UNESCAPED_UNICODE));
            $serviceName = $this->getServiceName($rpcArgs['service'], false);
            $service = new $serviceName();

            $methodName = $rpcArgs['method'];
            if (!method_exists($service, $methodName)) {
                throw new \Exception(get_lang('METHOD_NOT_FOUND', $methodName));
            }

            $result = call_user_func_array(array($service, $methodName), $rpcArgs['params']);
            LoggerUtil::info('RPC SUCC: ' . json_encode($result, JSON_UNESCAPED_UNICODE));

            return $result;
        } catch (\Exception $e) {
            LoggerUtil::error('RPC FAIL: ' . $e->getMessage());
            return data_pack(get_code('REMOTE_RPC_FAIL'), $e->getMessage());
        }
    }

}
