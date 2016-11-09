<?php

$serv = new swoole_websocket_server("0.0.0.0", 9502);

$serv->on('Open', function($server, $req) {
    echo "connection open: " . $req->fd . PHP_EOL;
});

$serv->on('Message', function($server, $frame) {
    echo "message: " . $frame->data . PHP_EOL;
    $server->push($frame->fd, json_encode(["hello", "world"]));
});

$serv->on('Close', function($server, $fd) {
    echo "connection close: " . $fd . PHP_EOL;
});

$serv->start();

