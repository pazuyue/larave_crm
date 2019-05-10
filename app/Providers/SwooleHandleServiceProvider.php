<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/10
 * Time: 14:45
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Handlers\SwooleHandle;

class SwooleHandleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    public function register()
    {
        $this->app->singleton('swoole',function(){
            return new SwooleHandle();
        });
    }
}