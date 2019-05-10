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
    public function onOpen($serv, $request)
    {
        echo 'onOpen';
    }
    public function onMessage($serv,$frame)
    {
        echo 'onMessage';
    }
    public function onClose($serv,$fd)
    {
        echo 'onClose';
    }

}