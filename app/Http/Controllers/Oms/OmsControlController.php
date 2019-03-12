<?php
/**OMS 控制层
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/12
 * Time: 13:48
 */
namespace App\Http\Controllers\Oms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Monolog\Processor\WebProcessor;

class OmsControlController extends Controller{

    public function getOmsLog(Request $request){
        dd(new WebProcessor($_SERVER));
        $result=DB::connection('mongodb')       //选择使用mongodb
        ->collection($request->channel)           //选择使用的集合
        ->insert([                          //插入数据
            'project'  => $request->project,
            'msg'     =>   $request->msg,
            'type'     =>   $request->type,
            'datetime'     =>   $request->datetime,
        ]);
        dd($result);
    }
}