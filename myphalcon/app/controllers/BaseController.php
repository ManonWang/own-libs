<?php

namespace App\Controllers;

use App\Library\AssetUtil;
use App\Library\ValidateUtil;
use App\Library\StringUtil;
use App\Library\HttpUtil;
use App\Library\LoggerUtil;

class BaseController extends \Phalcon\Mvc\Controller {

    public $denyActions = array();

    public function initialize() {
        $this->checkDenyAction();
        $this->paramsFillBack();
    }

    public function checkDenyAction() {
        $action  = strtolower($this->getActionName());
        $actions = array_map('strtolower', $this->denyActions);
        if (in_array($action, $actions)) {
            HttpUtil::redirect('/errors/show404');
            exit(0);
        }
    }

    public function paramsFillBack() {
        $this->view->userParams = $this->getUserParams();
    }

    public function getUserParams() {
        return StringUtil::trim($this->request->get());
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
        return $this->dispatcher->getControllerName();
    }

    public function getActionName() {
        return $this->dispatcher->getActionName();
    }

    public function getServiceName($serviceName = '', $short = false) {
        if (empty($serviceName)) {
            $serviceName = $this->getControllerName();
        }

        $shortName = $serviceName;
        $serviceName = 'App\\Service\\' . ucfirst($serviceName) . 'Service';
        if (!class_exists($serviceName)) {
            throw new \Exception(get_lang('CLASS_NOT_FOUND', $serviceName));
        }

        return $short ? $shortName : $serviceName;
    }

    public function getService($serviceName = '') {
        if (!$this->config->rpcCall) {
            $serviceName = $this->getServiceName($serviceName, false);
            return new $serviceName();
        }

        require VENDOR_PATH . '/Hprose/Hprose.php';
        $client = new \Hprose\Http\Client($this->config->rpcUri, false);
        $serviceName = $this->getServiceName($serviceName, true);
        return $client->$serviceName;
    }

    public function ajaxReturn($code, $msg = '', $data = array()) {
        $this->view->disable();
        $pack = is_array($code) ? $code : data_pack($code, $msg, $data);
        echo json_encode($pack, JSON_UNESCAPED_UNICODE);
        exit(0);
    }

    public function isAjax() {
        return $this->request->isAjax();
    }

    public function showError($error, $url = '', $stay = '3') {
        if (empty($error)) {
            $error = get_lang('UNKNOW_ERROR');
        } else{
            $error = is_array($error) ? current($error) : $error;
        }
        $this->view->setVar('error', $error);

        if (empty($url)) {
            $url = $this->errorBackUrl();
        }
        $this->view->setVar('url', $url);

        $this->view->setVar('stay', $stay);
        $this->view->render('errors', 'show');
        exit(0);
    }

    public function errorBackUrl() {
        $refer = HttpUtil::getRefererUrl();
        return empty($refer) ? HttpUtil::getIndexUrl() : $refer;
    }

    public function getFirstValiError($valiRes) {
        return empty($valiRes['error']) ? get_lang('PARAMA_ERROR') : current($valiRes['error']);
    }

}
