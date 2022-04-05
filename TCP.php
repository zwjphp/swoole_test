<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2022/4/5
 * Time: 18:16
 */

class TCP
{
    private $server = null;

    public function __construct()
    {
        $this->server = new Swoole\Server("127.0.0.1", 9501);
        $this->server->set([
            'worker_num' => 4,
            'max_request' => 50,
        ]);
        $this->server->on('Connect', [$this, "onConnect"]);
        $this->server->on('Receive', [$this, "onReceive"]);
        $this->server->on('Close', [$this, "onClose"]);

        //启动服务器
        $this->server->start();
    }

    public function onConnect($server, $fd) {
        echo "客户端id: {$fd} 链接.\n";
    }

    public function onReceive($server, $fd, $from_id, $data) {
        $server-> send($fd, "发送的数据:".$data);
    }

    public function onClose($server, $fd) {
        echo "客户端id: {$fd}关闭.\n";
    }

}

new TCP();