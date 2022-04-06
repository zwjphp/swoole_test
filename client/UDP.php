<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2022/4/5
 * Time: 18:50
 */

go(function(){
    $client = new \Swoole\Coroutine\Client(SWOOLE_SOCK_UDP);
    if (!$client->connect('127.0.0.1',9502, 0.5)) {
        echo "connect failed: Error:{$client->errCode}\n";
    }

    fwrite(STDOUT, "请输入:");
    $res = fgets(STDIN);
    $client->send($res);
    echo $client->recv();
    $client->close();
});