<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2022/4/5
 * Time: 18:16
 */

class HTTP
{
    private $server = null;

    public function __construct()
    {
        $this->server = new Swoole\Http\Server('0.0.0.0', 9503);
        // $this->server->set([
        //     'worker_num' => 4,
        //     'max_request' => 50,
        // ]);
        $this->server->on('Request', [$this, "onRequest"]);

        //启动服务器
        $this->server->start();
    }

    public function onRequest($request, $response) {
        $response->header('Content-Type', 'text/html; charset=utf-8');
        $response->end('<h1>Hello Swoole.#'. rand(1000, 2000).'</h1>');
    }
}

new HTTP();


