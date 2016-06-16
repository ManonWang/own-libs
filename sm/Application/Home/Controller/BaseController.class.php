<?php

namespace Home\Controller;

use Think\Controller;
use Home\Model\DictionaryModel;

class BaseController extends Controller {

    const MODEL_NAMESPACE_PREFIX = '\\Home\\Model\\';

    protected $model = null;

    public function _initialize() {
        $this->checkLogin();
        $this->initTime();
        $this->initMenu();
        $this->initModel();
    }

    protected function checkLogin() {
        $userInfo = session('userInfo');
        if (empty($userInfo)) {
            header("Location:/user/login.html");
        }
    }

    protected function initTime() {
        $timestamp = time();
        $this->assign("dateTime", date("Y-m-d H:i:s", $timestamp));
        $this->assign("dateWeek", week_num2word(date("w", $timestamp)));
    }

    protected function initMenu() {
        $riskMenu = C('risk_menu');
        $menuCat  = intval(trim(I('menu_cat')));
        if (!isset($riskMenu[$menuCat])) {
            $menuCat = $menuType = 1;
        }

        $menuType = intval(trim(I('menu_type')));
        if (!isset($riskMenu[$menuCat]['child'][$menuType])) {
            $menuType = 1;
        }

        $this->assign("risk_menu", $riskMenu);
        $this->assign('menu_cat',  $menuCat);
        $this->assign('menu_type', $menuType);
        $this->assign("breadcrumb", $riskMenu[$menuCat]);
    }

    protected function initModel() {
        $this->model = $this->getModel();    
    }

    public function getModel($className = CONTROLLER_NAME) {
        $modelName = self::MODEL_NAMESPACE_PREFIX . $className . 'Model';
        if (class_exists($modelName)) {
            return new $modelName();
        }
    }

    public function setDicData($keys) {
        $model = $this->getModel('Dictionary');
        $allTypes = DictionaryModel::$types;

        foreach ($keys as $key) {
            $types[] = $allTypes[$key];
        }

        $lists = $model->getListByType($types);

        $this->assign('allTypes', $allTypes);
        $this->assign('dicLists', $lists);

        return $lists;
    }

    public function ajaxReturn($code, $msg = '', $data = array()) {
        return parent::ajaxReturn(pack_data($code, $msg, $data));
    }

    public function outJson($data) {
        echo json_encode($data);
    }

}
