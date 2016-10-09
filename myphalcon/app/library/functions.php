<?php


function init_app_constant() {
    defined('APP_PATH')         || define('APP_PATH',         ROOT_PATH . '/app');
    defined('CONFIG_PATH')      || define('CONFIG_PATH',      APP_PATH  . '/config');
    defined('SERVICE_PATH')     || define('SERVICE_PATH',     APP_PATH  . '/service');
    defined('LIBRARY_PATH')     || define('LIBRARY_PATH',     APP_PATH  . '/library');
    defined('MODELS_PATH')      || define('MODELS_PATH',      APP_PATH  . '/models');
    defined('TASKS_PATH')       || define('TASKS_PATH',       APP_PATH  . '/tasks');
    defined('VENDOR_PATH')      || define('VENDOR_PATH',      APP_PATH  . '/vendor');
    defined('VIEWS_PATH')       || define('VIEWS_PATH',       APP_PATH  . '/views');
    defined('CONTROLLERS_PATH') || define('CONTROLLERS_PATH', APP_PATH  . '/controllers');
    defined('PUBLIC_PATH')      || define('PUBLIC_PATH',      ROOT_PATH . '/public');
    defined('CACHE_PATH')       || define('CACHE_PATH',       ROOT_PATH . '/cache');
    defined('LOGS_PATH')        || define('LOGS_PATH',        ROOT_PATH . '/logs');
}

function init_app_autoload() {
    $loader = new \Phalcon\Loader();

    $loader->registerNamespaces(array(
         'MyPhalcon\App\Controllers' => CONTROLLERS_PATH,
         'MyPhalcon\App\Models'      => MODELS_PATH,
         'MyPhalcon\App\Service'     => SERVICE_PATH,
         'MyPhalcon\App\Library'     => LIBRARY_PATH,
         'MyPhalcon\App\Config'      => CONFIG_PATH,
         'MyPhalcon\App\Tasks'       => TASKS_PATH,
     ));

    $loader->register();
}

function init_app_di() {
    $GLOBALS['app_di'] = IS_CLI_APP ? new \Phalcon\Di\FactoryDefault\Cli() : new Phalcon\Di\FactoryDefault();
}

function get_app_di() {
    return $GLOBALS['app_di'];
}

function get_cli_arguments($argv) {
    $arguments = array();
    foreach ($argv as $index => $arg) {
        if ($index == 1) {
            $arguments['task'] = $arg;
        } elseif ($index == 2) {
            $arguments['action'] = $arg;
        } elseif ($index >= 3) {
            $arguments['params'][] = $arg;
        }
    }

    define('CURRENT_TASK',   (isset($argv[1]) ? $argv[1] : null));
    define('CURRENT_ACTION', (isset($argv[2]) ? $argv[2] : null));
    return $arguments;
}

function run_cli_application($argv) {
    $di = get_app_di();
    $application = new \Phalcon\Cli\Console($di);
    $application->handle(get_cli_arguments($argv));
}

function run_cgi_application() {
    $di = get_app_di();
    $application = new \Phalcon\Mvc\Application($di);
    echo $application->handle()->getContent();
}

function data_pack($code, $error = '', $data = array()) {
    return array('code' => $code, 'error' => $error, 'data' => $data);
}

function is_succ_pack($data) {
    return $data['code'] == get_code('SUCC');
}

function get_code($key) {
    return MyPhalcon\App\Library\CodesUtil::get($key);
}

function get_lang($key) {
    $params = func_get_args();
    $params[0] = MyPhalcon\App\Library\LangsUtil::get($key);
    return call_user_func_array('sprintf', $params);
}

function p($data, $is_var_dump = false) {
    $is_var_dump ? var_dump($data) : print_r($data);
    echo PHP_EOL;
}
