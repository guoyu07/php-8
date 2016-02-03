<?php
/**
 * http_server.php
 *
 * @User    : wsj6563@gmail.com
 * @Date    : 16/1/29 14:18
 * @Encoding: UTF-8
 * @Created by PhpStorm.
 */
$http_server = new swoole_http_server('0.0.0.0', 9501);

$http_server->on('request', function ( $request, $response) {
    var_dump($request->server);
    var_dump($request->get, $request->post);
    $response->header("Content-type", "text/html;charset=utf-8");
    $response->end("<h1>#" . rand(100, 999) . "</h1>");
});

$http_server->start();