<?php

require 'config.php';

$connection = new AMQPConnection($connect);
$connection->setTimeOut(1);
$connection->connect();

$channel = new AMQPChannel($connection);

$queue = new AMQPQueue($channel);
$queue->setName($qname);
$queue->setFlags(AMQP_DURABLE);
$queue->declare(); 

function procMsg($envelope, $queue) {
    var_dump($envelope, $queue);
    $queue->ack($envelope->getdeliverytag());
};

while (true) {
   $queue->consume('procMsg');
}

$connection->disconnect();
