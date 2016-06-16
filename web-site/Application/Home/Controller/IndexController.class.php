<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller {

    public function index(){
        $this->display();
    }

    public function plugin() {
        echo json_encode(array('code' => 0, 'msg' => '参数错误', 'data' => array('id' => 1)));
    }

    public function remote() {
        echo json_encode(array('code' => 0));
    }

}
