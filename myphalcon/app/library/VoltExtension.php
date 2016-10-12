<?php

namespace App\Library;

class VoltExtension {

    public function compileFunction($name, $arguments) {
        if (function_exists($name)) {
            return $name . '('. $arguments . ')';
        }
    }

}
