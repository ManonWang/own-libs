<?php

namespace Home\Controller;

class IndexController extends BaseController {

    public function index() {
        $this->assign("data", array("name" => "name"));
        $this->display();
    }

}
