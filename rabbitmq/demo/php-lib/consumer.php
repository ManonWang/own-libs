<?php

require 'config.php';
require '../../PhpAmqpLib/autoload.php';

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPConnection;

try {
    $connection = new AMQPConnection($connect['host'], $connect['port'], $connect['login'], $connect['password'], $connect['vhost']);
    $channel = $connection->channel();

    $callback = function ($message) {
        echo $message->delivery_info['routing_key'], ':', $message->body, "\n";
        $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
    };

    $channel->queue_declare($qname, false, true, false, false);  
    $channel->basic_qos(0, 1, false);
    $channel->basic_consume($qname, '', false, false, false, false, $callback);
    while(count($channel->callbacks)) {
         $channel->wait();
    }

    $channel->close();
    $connection->close();
} catch (\Exception $e) {
    echo $e->getMessage(), "\n\n";
}
