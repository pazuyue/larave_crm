<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/11
 * Time: 19:02
 */
namespace App\Tool;
use Monolog\Logger;
use Monolog\Handler\MongoDBHandler;
use Monolog\Processor\WebProcessor;

class CreateCustomLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $route_info =request()->route()->getAction();   //获取请求参数
        $collection_info =explode('\\',$route_info['controller']);

        //根据请求的文件和方法判断mogodb的表和渠道
        if(!empty($collection_info) && is_array($collection_info)){
            $collection_info =$collection_info[count($collection_info)-1];
            $collection_info=explode('@',$collection_info);
            $channel=$collection_info[1];
            $collection =$collection_info[0];
        }
        //兜底策略
        if(empty($channel) && empty($collection)){
            $channel=$collection='Log';
        }

        $logger = new Logger($channel); // 创建 Logger
        $handler = new MongoDBHandler( // 创建 Handler
            new \MongoDB\Client($config['server']), // 创建 MongoDB 客户端（依赖 mongodb/mongodb）
            $config['database'],
            $collection
        );
        $handler->setLevel($config['level']);
        $logger->pushHandler($handler); // 挂载 Handler
        $logger->pushProcessor(new WebProcessor($_SERVER)); // 记录额外的请求信息
        return $logger;
    }
}