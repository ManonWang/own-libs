<?php

namespace MyPhalcon\App\Library;

class ClassUtil {

    public static function modifyPrivateProperties($object, $data) {
        $reflect = new \ReflectionClass(get_class($object));
        foreach ($data as $field => $value) {
            $property = $reflect->getProperty($field);
            if ($property) {
                $property->setAccessible(true);
                $property->setValue($object, $value);
                $property->setAccessible(false);
            }
        }
    }

    public static function getClassName($className) {
        $classNode = explode('\\', $className);
        return array_pop($classNode);
    }

}
