<?php

namespace Home\Controller;

class UserController extends BaseController {

    public function _initialize() {
        $this->checkLogin();
    }

    protected function checkLogin() {
        $userInfo = session('userInfo');
        if (!empty($userInfo)) {
            header("Location:/index/index.html");
        }
    }

    public function doLogin() {
        $username = I('username');
        $password = I('password');
        if ('admin' == $username && 'admin' == $password) {
            session('userInfo', array('user_name' => 'admin'));
            $this->ajaxReturn(0);
        } else {
            $this->ajaxReturn(1, '账号和密码不匹配');
        }
    }

    public function logout() {
        session('userInfo', null);
        header("Location:/user/login.html");
    }

}
