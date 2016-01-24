<?php

namespace PhpAmqpLib;

class AMQPAutoLoad {

    public static function registe() {
        spl_autoload_register(__NAMESPACE__ .'\AMQPAutoLoad::autoload');
    }

    public static function autoload($class) {
        $file = __DIR__ . str_replace('\\', '/', ltrim($class, __NAMESPACE__)) . '.php';
        if (file_exists($file)) {
            require $file;
            return true;
        }
        return false;
    }

}

$loader = new AMQPAutoLoad();
$loader::registe();
