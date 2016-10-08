<?php

namespace Home\Controller;

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
            $this->assign('data', $result);
            $this->display();
        }
    }

    public function show() {
        $valiRes = $this->runValidate();
        if (!$valiRes['result']) {
            return $this->isAjax() ? $this->ajaxReturn(get_code('PARAM_VALI_FAIL'), $valiRes['error'])
                                   : $this->showError($valiRes['error']);
        }

        $params = $this->runBefore($valiRes['data']);
        $facade = $this->getFacade();
        $result = $facade->show($params);
        if (!is_succ_pack($result)) {
            return $this->isAjax() ? $this->ajaxReturn($result) : $this->showError($result['error']);
        }

        $this->runAfter($params, $result['data']);
    }

    public function save() {
        $valiRes = $this->runValidate();
        if (!$valiRes['result']) {
            return $this->isAjax() ? $this->ajaxReturn(get_code('PARAM_VALI_FAIL'), $valiRes['error'])
                                   : $this->showError($valiRes['error']);
        }

        $params = $this->runBefore($valiRes['data']);
        $facade = $this->getFacade();
        $result = $facade->save($params);
        if (!is_succ_pack($result)) {
            return $this->isAjax() ? $this->ajaxReturn($result) : $this->showError($result['error']);
        }

        $this->runAfter($params, $result['data']);
    }

    public function del() {
        $valiRes = $this->runValidate();
        if (!$valiRes['result']) {
            return $this->isAjax() ? $this->ajaxReturn(get_code('PARAM_VALI_FAIL'), $valiRes['error'])
                                   : $this->showError($valiRes['error']);
        }

        $params = $this->runBefore($valiRes['data']);
        $facade = $this->getFacade();
        $result = $facade->del($params);
        if (!is_succ_pack($result)) {
            return $this->isAjax() ? $this->ajaxReturn($result) : $this->showError($result['error']);
        }

        $this->runAfter($params, $result['data']);
    }

    public function index() {
        $valiRes = $this->runValidate();
        if (!$valiRes['result']) {
            return $this->isAjax() ? $this->ajaxReturn(get_code('PARAM_VALI_FAIL'), $valiRes['error'])
                                   : $this->showError($valiRes['error']);
        }

        $params = $this->runBefore($valiRes['data']);
        $facade = $this->getFacade();
        $result = $facade->index($params);
        if (!is_succ_pack($result)) {
            return $this->isAjax() ? $this->ajaxReturn($result) : $this->showError($result['error']);
        }

        $this->runAfter($params, $result['data']);
    }

}
