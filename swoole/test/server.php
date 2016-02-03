<?php
/**
 * server.php
 *
 * @User    : wsj6563@gmail.com
 * @Date    : 16/1/29 11:54
 * @Encoding: UTF-8
 * @Created by PhpStorm.
 */
$serv = new swoole_server('127.0.0.1', 9501);
$serv->on('connect', function ($serv, $fd) {
    echo "Client:Connect.";
});

$serv->on('receive', function ($serv, $fd, $from_id, $data) {
    echo "Receive:".$data;
    $serv->send($fd, "Server:" . $data);
});

$serv->on('close', function ($serv, $fd) {
    echo "Client:Close.\n";
});

$serv->start();
