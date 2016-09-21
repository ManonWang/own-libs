<?php

namespace MyPhalcon\App\Tasks;

class ModelTask extends \Phalcon\CLI\Task {

    private $dbname = 'db_myPhalcon_r';
    private $modelNameSpace = 'MyPhalcon\App\Models\\';

    public function mainAction($args = array()) {
        if (!is_dir(MODELS_PATH)) {
            mkdir(MODELS_PATH, 0777, true);
        }

        $connection = $this->{$this->dbname};
        $tables = $connection->listTables();

        foreach ($tables as $table) {
            $columnsDefaultValues = array('//这之下是系统生成的代码，请勿修改');
            $className = ucfirst(preg_replace('~_([a-z])~e', "strtoupper('\\1')", $table));
            $columnsDefaultMap = $this->getDefaultValuesMap($connection->fetchAll("DESC $table"));
            foreach ($connection->describeColumns($table) as $columnObj) {
                $columnName = $columnObj->getName();
                if ($columnObj->isNotNull() && $columnsDefaultMap[$columnName] !== null) {
                    if ($columnsDefaultMap[$columnName] == 'CURRENT_TIMESTAMP') {
                        $columnsDefaultValues[] = sprintf('$this->%s = date("Y-m-d H:i:s");', $columnName);
                    } else {
                        $columnsDefaultValues[] = sprintf('$this->%s = %s;', $columnName, var_export($columnsDefaultMap[$columnName], true));
                    }
                }
            }

            $columnsDefaultValues[] = '//这之上是系统生成的代码，请勿修改';
            $this->setClassContent($className, $columnsDefaultValues);
        }
    }

    private function setClassContent($className, $columnsDefaultValues) {
        $fileName = sprintf('%s/%s.php', MODELS_PATH, $className);
        if (!file_exists($fileName)) {
            $classContent =<<<EOT
<?php

namespace MyPhalcon\App\Models;

use MyPhalcon\App\Models\BaseModel;

class <<<modelName>>> extends BaseModel {

    public function onConstruct() {
        <<<defaultValue>>>
    }

}
EOT;
            $lastContent = str_replace(array('<<<modelName>>>', '<<<defaultValue>>>'), array($className, implode("\n        ", $columnsDefaultValues)), $classContent);
            file_put_contents($fileName, $lastContent);
        } else {
             $fullClassName = $this->modelNameSpace . $className;
             if (!class_exists($fullClassName)) {
                 throw new \Exception(sprintf("错误: Model文件 %s 中, 找不到类 %s ", $fileName, $fullClassName));
             }

             $classContent = file_get_contents($fileName);
             $reflectionClass = new \ReflectionClass($fullClassName);
             if (!$reflectionClass->hasMethod('onConstruct')) {
                  $classContent = preg_replace("~(\s*class\s+{$className}\s+extends\s+[^{]+{)~i", '\\1'. "\n\n    public function onConstruct() {\n        <<<defaultValue>>>\n    }\n", $classContent);
                  $lastContent = str_replace(array('<<<defaultValue>>>'), array(implode("\n        ", $columnsDefaultValues)), $classContent);
                  file_put_contents($fileName, $lastContent);
             } else {

             }
        }

    }

   private function getClassFile($className) {
      return sprintf('%s/%s.php', MODELS_PATH, $className);
   }

    private function getDefaultValuesMap($columns) {
       $ret = array();
       foreach ($columns as $item) {
           $ret[$item['Field']] = $item['Default'];
       }
       return $ret;
    }

}

<<<EOT
<?php

namespace MyPhalcon\App\Models;

use MyPhalcon\App\Models\BaseModel;

class <<<className>>> extends BaseModel {

    public function onConstruct() {
        //系统生成，请勿修改此方法

        //系统生成，请勿修改此方法
    }

}
EOT;

