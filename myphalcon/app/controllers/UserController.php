<?php

namespace MyPhalcon\App\Controllers;

use MyPhalcon\App\Controllers\DefaultController;

class UserController extends DefaultController {

    /*************************展示*****************************/
    public function validateShow() {
        return $this->validate(array('id' => array('int' => '参数错误')));
    }

    public function afterShow($params, $result) {
        $result['hoppy'] = explode(",", $result['hoppy']);
        $this->view->data = $result;
    }


    /*************************保存*****************************/
    public function beforeSave($params) {
        $params['hoppy'] = implode(',', $params['hoppy']);
        return $params;
    }

    public function validateSave() {
         return $this->validate(array(
           'id'          => array('int'),
           'en_name'     => array('not-empty', 'max-len:50'),
           'zh_name'     => array('not-empty', 'min-len:2', 'max-len:10', 'word'),
           'mobile'      => array('not-empty', 'mobile'),
           'email'       => array('not-empty', 'max-len:255', 'email'),
           'age'         => array('not-empty', 'min-val:10', 'max-val:100', 'int'),
           'url'         => array('not-empty', 'max-len:255', 'url'),
           'password'    => array('not-empty', 'min-len:6', 'pwd-num'),
           'repassword'  => array('confirm:password'),
           'hoppy'       => array('not-empty', 'count:2'),
           'sex'         => array('not-empty', 'in-list:1,2'),
           'city'        => array('not-empty', 'in-list:1,2'),
           'file'        => array('file', 'ext-in:png,jpeg'),
           'intro',
         ));
    }

    public function afterSave($params, $result) {
        $result['hoppy'] = explode(",", $result['hoppy']);
        return $this->ajaxReturn(get_code('SUCC'), null, $result);
    }


    /*************************删除*****************************/
    public function validateDel() {
        return $this->validate(array('id' => array('not-empty', 'int')));
    }

}
