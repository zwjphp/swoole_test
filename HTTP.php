<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2022/4/5
 * Time: 18:16
 */

class HTTP
{
    private $http = null;

    public function __construct()
    {
        $this->http = new Swoole\Http\Server('0.0.0.0', 9503);
        $this->http->set([
            'enable_static_handler' => true,
            'document_root' => "/home/work/php/swoole_test/static",
        ]);
        $this->http->on('Request', [$this, "onRequest"]);

        //启动服务器
        $this->http->start();
    }

    public function onRequest($request, $response) {
        var_dump($request->get, $request->post);


        $response->header('Content-Type', 'text/html; charset=utf-8');
        $response->end('<h1>Hello Swoole.#'. rand(1000, 2000).'</h1>');
    }
}

new HTTP();


