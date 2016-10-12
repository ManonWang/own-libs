<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DefaultController extends BaseController {

    public function runValidate() {
        $methodName = 'valid' . $this->getActionName();
        if (method_exists($this, $methodName)) {
            return $this->$methodName();
        }

       return array(
          'result' => true,
          'error'  => '',
          'data'   => $this->getUserParams(),
       );
    }

    public function runBefore($params) {
        $methodName = 'before' . $this->getActionName();
        if (method_exists($this, $methodName)) {
            return $this->$methodName($params);
        }

        return $params;
    }

    public function runAfter($params, $result) {
        $methodName = 'after' . $this->getActionName();
        if (method_exists($this, $methodName)) {
            return $this->$methodName($params, $result);
        }

        if ($this->isAjax()) {
            $this->ajaxReturn(get_code('SUCC'), null, $result);
        } else {
            $this->view->data = $result;
        }
    }

    public function showAction() {
        $valiRes = $this->runValidate();
        if (!$valiRes['result']) {
            return $this->isAjax() ? $this->ajaxReturn(get_code('PARAM_VALI_FAIL'), $valiRes['error'])
                                   : $this->showError($valiRes['error']);
        }

        $params = $this->runBefore($valiRes['data']);
        $service = $this->getService();
        $result = $service->show($params);
        if (!is_succ_pack($result)) {
            return $this->isAjax() ? $this->ajaxReturn($result) : $this->showError($result['error']);
        }

        $this->runAfter($params, $result['data']);
    }

    public function saveAction() {
        $valiRes = $this->runValidate();
        if (!$valiRes['result']) {
            return $this->isAjax() ? $this->ajaxReturn(get_code('PARAM_VALI_FAIL'), $valiRes['error'])
                                   : $this->showError($valiRes['error']);
        }

        $params = $this->runBefore($valiRes['data']);
        $service = $this->getService();
        $result = $service->save($params);
        if (!is_succ_pack($result)) {
            return $this->isAjax() ? $this->ajaxReturn($result) : $this->showError($result['error']);
        }

        $this->runAfter($params, $result['data']);
    }

    public function delAction() {
        $valiRes = $this->runValidate();
        if (!$valiRes['result']) {
            return $this->isAjax() ? $this->ajaxReturn(get_code('PARAM_VALI_FAIL'), $valiRes['error'])
                                   : $this->showError($valiRes['error']);
        }

        $params = $this->runBefore($valiRes['data']);
        $service = $this->getService();
        $result = $service->del($params);
        if (!is_succ_pack($result)) {
            return $this->isAjax() ? $this->ajaxReturn($result) : $this->showError($result['error']);
        }

        $this->runAfter($params, $result['data']);
    }

    public function indexAction() {
        $valiRes = $this->runValidate();
        if (!$valiRes['result']) {
            return $this->isAjax() ? $this->ajaxReturn(get_code('PARAM_VALI_FAIL'), $valiRes['error'])
                                   : $this->showError($valiRes['error']);
        }

        $params = $this->runBefore($valiRes['data']);
        $service = $this->getService();
        $result = $service->index($params);
        if (!is_succ_pack($result)) {
            return $this->isAjax() ? $this->ajaxReturn($result) : $this->showError($result['error']);
        }

        $this->runAfter($params, $result['data']);
    }

}
