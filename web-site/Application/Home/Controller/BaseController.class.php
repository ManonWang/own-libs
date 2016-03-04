<?php

namespace Home\Controller;

use Think\Controller;

class BaseController extends Controller {
    
    public function _initialize() {
        $this->setDefaultTheme();
    }
    
    public function setDefaultTheme() {
        if (isset($_COOKIE['theme']) && in_array($_COOKIE['theme'], array('pc', 'wap'))) {
            $theme = $_COOKIE['theme'];
        } else {
            $theme = get_theme();
            setcookie('theme', $theme);
        }
        C('DEFAULT_THEME', $theme);
    }

}
