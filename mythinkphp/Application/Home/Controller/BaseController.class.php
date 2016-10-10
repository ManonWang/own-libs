<?php

namespace Home\Controller;

use Think\Controller;
use Common\Library\HttpUtil;
use Common\Library\StringUtil;
use Common\Library\ValidateUtil;
use Common\Library\LoggerUtil;

class BaseController extends Controller {

    public $denyActions = array();

    public function _initialize() {
        $this->checkDenyAction();
        $this->paramsFillBack();
    }

    public function checkDenyAction() {
        $action  = strtolower($this->getActionName());
        $actions = array_map('strtolower', $this->denyActions);
        if (in_array($action, $actions)) {
            HttpUtil::redirect('/Errors/show404');
            exit(0);
        }
    }

    public function paramsFillBack() {
        $this->assign('userParams', $this->getUserParams());
    }

    public function getUserParams() {
        return StringUtil::trim(I());
    }

    public function validate($rules, $params = array()) {
        if (empty($params)) {
            $params = $this->getUserParams();
        } else {
            $params = StringUtil::trim($params);
        }
        return ValidateUtil::validate($params, $rules);
    }

    public function getControllerName() {
        return CONTROLLER_NAME;
    }

    public function getActionName() {
        return ACTION_NAME;
    }

    public function getServiceName($serviceName = '', $short = false) {
        if (empty($serviceName)) {
            $serviceName = $this->getControllerName();
        }

        $shortName = $serviceName;
        $serviceName = MODULE_NAME . '\\Service\\' . ucfirst($serviceName) . 'Service';
        if (!class_exists($serviceName)) {
            throw new \Exception(get_lang('CLASS_NOT_FOUND', $serviceName));
        }

        return $short ? $shortName : $serviceName;
    }

    public function getService($serviceName = '') {
        if (!C('RPC_CALL')) {
            $serviceName = $this->getServiceName($serviceName, false);
            return new $serviceName();
        }

        vendor('Hprose.Hprose');
        $client = new \Hprose\Http\Client(C('RPC_URI'), false);
        $serviceName = $this->getServiceName($serviceName, true);
        return $client->$serviceName;
    }

    public function ajaxReturn($code, $msg = '', $data = array()) {
        $pack = is_array($code) ? $code : data_pack($code, $msg, $data);
        echo json_encode($pack, JSON_UNESCAPED_UNICODE);
        exit(0);
    }

    public function isAjax() {
        return IS_AJAX;
    }

    public function showError($error, $url = '', $stay = '3') {
        if (empty($error)) {
            $error = get_lang('UNKNOW_ERROR');
        } else{
            $error = is_array($error) ? current($error) : $error;
        }
        $this->assign('error', $error);

        if (empty($url)) {
            $url = $this->errorBackUrl();
        }
        $this->assign('url', $url);

        $this->assign('stay', $stay);
        $this->display('Errors:show');
        exit(0);
    }

    public function errorBackUrl() {
        $refer = HttpUtil::getRefererUrl();
        return empty($refer) ? HttpUtil::getIndexUrl() : $refer;
    }

    public function getFirstValiError($valiRes) {
        return empty($valiRes['error']) ? get_lang('PARAMA_ERROR') : current($valiRes['error']);
    }

    public function _empty() {
        HttpUtil::redirect('/Errors/show404');
    }

}
