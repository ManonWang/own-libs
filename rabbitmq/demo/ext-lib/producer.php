<?php

require 'config.php';

$connection = new AMQPConnection($connect);
$connection->connect();

$channel = new AMQPChannel($connection);

$exchange = new AMQPExchange($channel);
$exchange->setName($exname);
$exchange->setType(AMQP_EX_TYPE_TOPIC);
$exchange->setFlags(AMQP_DURABLE);
$exchange->declare();

$queue = new AMQPQueue($channel);
$queue->setName($qname);
$queue->setFlags(AMQP_DURABLE);
$queue->declare(); 
$queue->bind($exname, $routekey);

$channel->startTransaction();
$message = json_encode(array('Hello World! 测试消息！','TOPIC'));
$exchange->publish($message, $routekey);
$channel->commitTransaction();

$connection->disconnect();
