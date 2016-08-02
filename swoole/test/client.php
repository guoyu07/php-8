<?php
/**
 * client.php
 *
 * @User    : wsj6563@gmail.com
 * @Date    : 16/1/29 13:45
 * @Encoding: UTF-8
 * @Created by PhpStorm.
 */
$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);


$client->on('connect', function (swoole_client $cli) {
    $cli->send("GET / HTTP/1.1\r\n\r\n");
});

$client->on('receive', function (swoole_client $cli, $data) {
    echo "Receive:$data";
    $cli->send(date('Y-m-d H:i:s'));
});

$client->on('error', function (swoole_client $cli) {
    echo "Error\n";
});

$client->on('close', function (swoole_client $cli) {
    echo "Connection close\n";
});

$client->connect('127.0.0.1', 9501);
//over
