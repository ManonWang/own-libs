<?php

namespace Home\Controller;

class ErrorsController extends BaseController {

    public function show404Action() {
        $this->display();
    }

    public function show500Action() {
        $this->display();
    }

}
