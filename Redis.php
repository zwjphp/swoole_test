<?php
use Swoole\Coroutine\Http\Server;
use function Swoole\Coroutine\run;

class re {
  public function index() {
    run(function () {
      $redis = new Redis();
      $redis->connect('127.0.0.1', 6379);
      var_dump($redis->get('key'));
      sleep(5);
    });
  }

}

$re = new re();
$re->index();