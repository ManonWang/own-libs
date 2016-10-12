<?php

namespace App\Config;

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use App\Library\NotFoundPlugin;
use App\Library\ElementsPlugin;
use App\Library\ClassUtil;
use App\Library\LoggerUtil;
use App\Library\VoltExtension;

class ServiceConfig {

    private static function getConfig() {
        $env = get_cfg_var('phalcon.env') ? : 'dev';
        $config = require CONFIG_PATH . '/' . ucfirst($env) . 'Config.php';
        return new \Phalcon\Config($config);
    }

    public static function register() {
        IS_CLI_APP ? self::cliRegister() : self::cgiRegister();
    }

    //命令行应用
    private static function cliRegister() {
        $di = get_app_di();
        $config = self::getConfig();
        self::registCommonService($di, $config);

        $di->setShared('dispatcher', function () {
            $dispatcher = new \Phalcon\Cli\Dispatcher();
            $dispatcher->setDefaultNamespace("App\\Tasks\\");
            return $dispatcher;
        });
    }

    //web应用
    private static function cgiRegister() {
        $di = get_app_di();
        $config = self::getConfig();
        self::registCommonService($di, $config);

        $di->setShared('router', function () {
            $router = new \Phalcon\Mvc\Router();
            $router->removeExtraSlashes(true);
            $router->add('/:controller/:action/:params', array(
                'controller' => 1,
                'action'     => 2,
                'params'     => 3,
            ));
            return $router;
        });

        $di->setShared('dispatcher', function () {
            $eventsManager = new \Phalcon\Events\Manager();
            $eventsManager->attach('dispatch:beforeException', new NotFoundPlugin());

            $dispatcher = new \Phalcon\Mvc\Dispatcher();
            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDefaultNamespace("App\\Controllers\\");
            return $dispatcher;
        });

        $di->setShared('view', function () use ($config) {
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir($config->view->templatePath);
            $view->registerEngines(array(
                '.html' => function($view, $di) {
                      $config = $di->get('config');
                      $compiledPath = $config->view->compiledPath;
                      if (!file_exists($compiledPath)) {
                         mkdir($compiledPath, 0744, true);
                      }

                      $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
                      $volt->setOptions(array(
                          'compiledPath' => $compiledPath,
                          'compiledExtension' => $config->view->compiledExtension,
                          'compileAlways' => isset($config->view->compileAlways) ? : false,
                      ));

                      $compiler = $volt->getCompiler();
                      $compiler->addExtension(new VoltExtension());

                      $autoEscape = isset($config->view->autoEscape) ? : true;
                      ClassUtil::modifyPrivateProperties($compiler, array('_autoescape' => $autoEscape));

                      return $volt;
                 }
            ));
            return $view;
        });

        $di->setShared('elements', function () {
             return new ElementsPlugin();
        });

    }

    private static function registCommonService($di, $config) {
        $di->setShared('config', $config);

        $di->setShared('profiler', function () {
             return new \Phalcon\Db\Profiler();
         });

        $di->setShared('modelsMetadata', function() use ($di, $config) {
            if ('file' == $config->metaData->saveType) {
                $savePath = $config->metaData->savePath;
                if (!file_exists($savePath)) {
                    mkdir($savePath, 0744, true);
                }
                $metaData = new \Phalcon\Mvc\Model\Metadata\Files(array(
                    'metaDataDir' => $savePath
                ));
                return $metaData;
            }
        });

        $di->setShared('db_myPhalcon_w', function () use ($di, $config) {
             $profiler = $di->getProfiler();
             $eventsManager = new \Phalcon\Events\Manager();
             $eventsManager->attach('db', function ($event, $connection) use ($profiler) {
                  if ($event->getType() == 'beforeQuery') {
                     $profiler->startProfile($connection->getSQLStatement(), $connection->getSqlVariables(), $connection->getSQLBindTypes());
                  }

                  if ($event->getType() == 'afterQuery') {
                     $profiler->stopProfile();
                     $profile = $profiler->getLastProfile();
                     LoggerUtil::info(sprintf('SQL %s , cost time : %s', $profile->getSQLStatement(), $profile->getTotalElapsedSeconds()));
                  }
             });

             $db = new DbAdapter(array(
                   'host'     => $config->mysql->myPhalcon_w->host,
                   'username' => $config->mysql->myPhalcon_w->username,
                   'password' => $config->mysql->myPhalcon_w->password,
                   'dbname'   => $config->mysql->myPhalcon_w->dbname,
                   'port'     => $config->mysql->myPhalcon_w->port,
              ));

              $db->setEventsManager($eventsManager);
              return $db;
        });

        $di->setShared('db_myPhalcon_r', function () use ($di, $config) {
             $profiler = $di->getProfiler();
             $eventsManager = new \Phalcon\Events\Manager();
             $eventsManager->attach('db', function ($event, $connection) use ($profiler) {
                  if ($event->getType() == 'beforeQuery') {
                     $profiler->startProfile($connection->getSQLStatement(), $connection->getSqlVariables(), $connection->getSQLBindTypes());
                  }

                  if ($event->getType() == 'afterQuery') {
                     $profiler->stopProfile();
                     $profile = $profiler->getLastProfile();
                     LoggerUtil::info(sprintf('SQL: %s , COST TIME: %s', $profile->getSQLStatement(), $profile->getTotalElapsedSeconds()));
                  }
             });

             $db = new DbAdapter(array(
                   'host'     => $config->mysql->myPhalcon_r->host,
                   'username' => $config->mysql->myPhalcon_r->username,
                   'password' => $config->mysql->myPhalcon_r->password,
                   'dbname'   => $config->mysql->myPhalcon_r->dbname,
                   'port'     => $config->mysql->myPhalcon_r->port,
              ));

              $db->setEventsManager($eventsManager);
              return $db;
        });

        $di->setShared('redisCache', function () use ($di, $config) {
             require VENDOR_PATH . '/predis/Autoloader.php';
             \Predis\Autoloader::register();
             $host = $config->redisCache->host;
             $port = $config->redisCache->port;
             return new \Predis\Client("tcp://{$host}:{$port}");
        });

        $di->setShared('curl', function () use ($di, $config) {
            require VENDOR_PATH . '/Curl/Autoloader.php';
            \Curl\Autoloader::register();
            return new \Curl\Curl();
        });

        $di->setShared('image', function () use ($di, $config) {
            require VENDOR_PATH . '/Image/Autoloader.php';
            \Image\Autoloader::register();
            return new \Image\Image(\Image\Image::IMAGE_IMAGICK);
        });
    }

}
