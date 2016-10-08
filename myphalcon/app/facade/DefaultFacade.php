<?php

namespace MyPhalcon\App\Facade;

use MyPhalcon\App\Facade\BaseFacade;

class DefaultFacade extends BaseFacade  {

    public $data = array();

    /*============================展示=======================================*/
    //服务端验证
    public function beforeShow() {
        return data_pack(get_code('SUCC'));
    }

    //业务逻辑
    public function show($params) {
        $this->data = array('input' => $params);

        $beforeResult = $this->beforeShow();
        if (!is_succ_pack($beforeResult)) {
            return $beforeResult;
        }

        //新增
        if (empty($params['id'])) {
            $facadeResult = array();
            $this->data['origin'] = $facadeResult;
            return $this->afterShow();
        }

        //更新
        $facadeResult = $this->getRowById($this->data['input']['id']);
        if (empty($facadeResult) || $facadeResult['is_delete']) {
            return data_pack(get_code('FIND_DATA_FAIL'), get_lang('DATA_NOT_FOUND'));
        }
        $this->data['origin'] = $facadeResult;

        return $this->afterShow();
    }

    //其它数据处理, 如日志记录
    public function afterShow() {
        return data_pack(get_code('SUCC'), null, $this->data['origin']);
    }

    /*============================保存=======================================*/
    //服务端验证
    public function beforeSave() {
        return data_pack(get_code('SUCC'));
    }

    //业务逻辑
    public function save($params) {
        $this->data = array('input' => $params);

        //更新
        $facadeResult = array();
        if (!empty($params['id'])) {
            $facadeResult = $this->getRowById($params['id']);
            if (empty($facadeResult) || $facadeResult['is_delete']) {
                return data_pack(get_code('FIND_DATA_FAIL'), get_lang('DATA_NOT_FOUND'));
            }
        }

        $this->data['origin'] = $facadeResult;
        $beforeResult = $this->beforeSave();
        if (!is_succ_pack($beforeResult)) {
            return $beforeResult;
        }

        $saveData = array_merge($this->data['origin'], $this->data['input']);
        $facadeResult = $this->saveRow($saveData);
        if (false === $facadeResult) {
            return data_pack(get_code('SAVE_DATA_FAIL'), get_lang('OPERATION_FAIL'));
        }
        $this->data['latest'] = $facadeResult;

        return $this->afterSave();
    }

    //其它数据处理, 如日志记录
    public function afterSave() {
        return data_pack(get_code('SUCC'), null, $this->data['latest']);
    }

    /*============================删除=======================================*/
    //服务端验证
    public function beforeDel() {
        return data_pack(get_code('SUCC'));
    }

    //服务端验证
    public function del($params) {
        $this->data = array('input' => $params);

        $facadeResult = $this->getRowById($this->data['input']['id']);
        if (empty($facadeResult) || $facadeResult['is_delete']) {
            return data_pack(get_code('FIND_DATA_FAIL'), get_lang('DATA_NOT_FOUND'));
        }

        $this->data['origin'] = $facadeResult;
        $beforeResult = $this->beforeDel();
        if (!is_succ_pack($beforeResult)) {
            return $beforeResult;
        }

        $saveData = $this->data['origin'];
        $saveData['is_delete'] = 1;

        $facadeResult = $this->saveRow($saveData);
        if (false === $facadeResult) {
            return data_pack(get_code('SAVE_DATA_FAIL'), get_lang('OPERATION_FAIL'));
        }
        $this->data['latest'] = $facadeResult;

        return $this->afterDel();
    }

    //其它数据处理, 如日志记录
    public function afterDel() {
        return data_pack(get_code('SUCC'), null, $this->data['latest']);
    }

    /*============================首页=======================================*/
    //服务端验证
    public function beforeIndex() {
        return data_pack(get_code('SUCC'));
    }

    //首页
    public function index($params) {
        $this->data = array('input' => $params);

        $beforeResult = $this->beforeIndex();
        if (!is_succ_pack($beforeResult)) {
            return $beforeResult;
        }

        $model = $this->getModel();
        $facadeResult = $model->getPagedList($this->data['input']);
        if (false === $facadeResult) {
            return data_pack(get_code('FIND_DATA_FAIL'), get_lang('OPERATION_FAIL'));
        }
        $this->data['origin'] = $facadeResult;

        return $this->afterIndex();
    }

    //其它数据处理, 如日志记录
    public function afterIndex() {
        return data_pack(get_code('SUCC'), null, $this->data['origin']);
    }

}
