<?php

require 'config.php';
require '../../PhpAmqpLib/autoload.php';

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPConnection;

try {
    $connection = new AMQPConnection($connect['host'], $connect['port'], $connect['login'], $connect['password'], $connect['vhost']);
    $channel = $connection->channel();

    $channel->exchange_declare($exname, 'topic', false, true, false);
    $channel->queue_declare($qname, false, true, false, false);  
    $channel->queue_bind($qname, $exname, $routeFilter);

    $routeKey = "a.routekey.b";
    $message = new AMQPMessage('TEST MESSAGE! 测试消息！', array('delivery_mode' => 2));

    //$channel->tx_select();
    $channel->basic_publish($message, $exname, $routeKey);
    //$channel->tx_commit();

    $channel->close();
    $connection->close();
} catch (\Exception $e) {
    //$channel->tx_rollback();
    echo $e->getMessage(), "\n\n";
}
