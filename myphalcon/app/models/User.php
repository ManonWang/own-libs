<?php

namespace MyPhalcon\App\Models;

use MyPhalcon\App\Models\BaseModel;

class User extends BaseModel {

    public function onConstruct() {
        //这之下是系统生成的代码，请勿修改
        $this->zh_name = '';
        $this->is_delete = '0';
        $this->age = '10';
        $this->a = date("Y-m-d H:i:s");
        //这之上是系统生成的代码，请勿修改
    }


    public function onConstructaaa() {
        //这之下是系统生成的代码，请勿修改
        $this->zh_name = '';
        $this->is_delete = '0';
        $this->age = '10';
        $this->a = date("Y-m-d H:i:s");
        //这之上是系统生成的代码，请勿修改
    }

}
