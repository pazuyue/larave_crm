<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/10
 * Time: 14:44
 */
namespace App\Handlers;


class SwooleHandle
{
    public function __construct()
    {

    }
    /**
     * 数据接收回调
     */
    public function onReceive($serv, $fd, $from_id, $data){
        echo 'onReceive';
        $serv->send($fd,$data."\r\n");
    }


}