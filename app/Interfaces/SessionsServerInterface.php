<?php


/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/17
 * Time: 19:59
 */
namespace App\Interfaces;

interface SessionsServerInterface
{
    /**登陆
     * @param array $credentials
     * @param $request
     * @return mixed
     */
    public function attempt(array $credentials,$request);
}