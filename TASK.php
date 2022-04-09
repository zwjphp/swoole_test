<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2022/4/5
 * Time: 18:16
 */

class TASK
{
    private $ws = null;

    public function __construct()
    {
        $this->ws = new Swoole\WebSocket\Server('0.0.0.0', 9502);
        $this->ws->set([
            'task_worker_num' => 4
        ]);
        $this->ws->on('Open', [$this, "onOpen"]);
        $this->ws->on('Message', [$this, "onMessage"]);
        $this->ws->on('Close', [$this, "onClose"]);
        $this->ws->on('Task', [$this, "onTask"]);
        $this->ws->on('Finish', [$this, "onFinish"]);

        //启动服务器
        $this->ws->start();
    }

    public function onOpen($ws, $request) {
        $ws->push($request->fd, "hello,welcome\n");
    }

    public function onMessage($ws, $frame) {
        echo "Message: {$frame->data}\n";
        foreach ($ws -> connections as $fd) {
            if ($fd == $frame->fd) {
                $ws->onTask([
                    'fd' => $fd,
                    'message' => "我: {$frame -> data}"
                ]);
                $ws->push($fd, "我: {$frame -> data}");
            } else {
                $ws ->push($fd, "对方：{$frame -> data}");
            }
        }
    }

    public function onClose($ws, $fd) {
        echo "client:{$fd} is closed\n";
    }


    public function onTask($ws, $task_id, $reactor_id, $data) {
        var_dump($data);
        $ws->onFinish($data);
    }


    public function onFinish($ws, $task_id, $data) {
        var_dump($data);
        
    }
}

new TASK();


