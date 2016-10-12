<?php

namespace App\Controllers;

class IndexController extends BaseController {

    public function indexAction() {
        p($this->validate(array(
             'date' => array('date:Y-m-d'),
             'datetime' => array('not-empty', 'datetime:Y-m-d H:i:s'),
          ),
          array(
            'date' => '2015-09-30',
          )));
    }

}
