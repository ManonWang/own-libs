<?php

namespace MyPhalcon\App\Library;

class VoltExtension {

    public function compileFunction($name, $arguments) {
        if (function_exists($name)) {
            return $name . '('. $arguments . ')';
        }
    }

}
