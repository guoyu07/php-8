<?php
/**
 * ws_server.php
 *
 * @User    : wsj6563@gmail.com
 * @Date    : 16/1/29 14:38
 * @Encoding: UTF-8
 * @Created by PhpStorm.
 */

$ws = new swoole_websocket_server('0.0.0.0', 9502);
$ws->on('open', function (swoole_websocket_server $ws, $request) {
    var_dump($request->fd, $request->get, $request->server);
    $ws->push($request->fd, "hello,welcome\n");
});

$ws->on('message', function (swoole_websocket_server $ws, $frame) {
    echo "Message:{$frame->data}\n";
    $ws->push($frame->fd, "server:{$frame->data}");
});

$ws->on('close', function (swoole_websocket_server $ws, $fd) {
    echo "Client-{$fd} is closed";
});

$ws->start();