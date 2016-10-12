<?php

namespace App\Library;

use \Phalcon\Events\Event;
use \Phalcon\Mvc\User\Plugin;
use \Phalcon\Dispatcher;
use \Phalcon\Mvc\Dispatcher\Exception as DispatcherException;
use \Phalcon\Mvc\Dispatcher as MvcDispatcher;
use App\Library\LoggerUtil;
use App\Library\HttpUtil;

class NotFoundPlugin extends Plugin
{

    public function beforeException(Event $event, MvcDispatcher $dispatcher, \Exception $exception)
    {
        if ($exception instanceof DispatcherException) {
            switch ($exception->getCode()) {
                case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                     HttpUtil::redirect('/errors/show404');
                     return false;
            }
        }

        LoggerUtil::error($exception->getMessage());

        HttpUtil::redirect('/errors/show500');

        return false;
    }

}
