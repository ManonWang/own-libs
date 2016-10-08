<?php

namespace Home\Controller;

class ErrorsController extends BaseController {

    public function show404() {
        $this->display();
    }

    public function show500() {
        $this->display();
    }

}
