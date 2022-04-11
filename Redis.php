<?php
use Swoole\Runtime;
use Swoole\Coroutine;
use function Swoole\Coroutine\run;

class re {
    public function index() {
      Swoole\Runtime::enableCoroutine()

      Co\run(function() {
        for ($c = 100; $c--;) {
            go(function () {//创建100个协程
                $redis = new Redis();
                $redis->connect('127.0.0.1', 6379);//此处产生协程调度，cpu切到下一个协程，不会阻塞进程
                $redis->get('aaa');//此处产生协程调度，cpu切到下一个协程，不会阻塞进程
                sleep(5);
            });
        }
    });
    }



}