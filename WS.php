<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2022/4/5
 * Time: 18:16
 */

class WS
{
    private $http = null;

    public function __construct()
    {
        $this->http = new Swoole\WebSocket\Server('0.0.0.0', 9502);
        // $this->http->set([
        //     'enable_static_handler' => true,
        //     'document_root' => "/home/work/php/swoole_test/static",
        // ]);
        $this->http->on('Open', [$this, "onOpen"]);
        $this->http->on('Message', [$this, "onMessage"]);
        $this->http->on('Close', [$this, "onClose"]);

        //启动服务器
        $this->http->start();
    }

    public function onOpen($ws, $request) {
        $ws->push($request->fd, "hello,welcome\n");
    }

    public function onMessage($ws, $frame) {
        echo "Message: {$frame->data}\n";
        foreach ($ws -> connections as $fd) {
            if ($fd == $frame->fd) {
                $ws->push($fd, "我: {$frame -> data}");
            } else {
                $ws ->push($fd, "对方：{$frame -> data}");
            }
        }
    }

    public function onClose($ws, $fd) {
        echo "client:{$fd} is closed\n";
    }
}

new WS();


