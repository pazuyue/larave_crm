<?php

namespace App\Console\Commands;


use App\Handlers\SwooleHandle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class Swoole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Swoole';

    protected $swoole_handle = null;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arg=$this->argument('action');
        switch($arg)
        {
            case 'start':
                $this->info('swoole observer started');
                $this->start();
                break;
        }
    }

    private function start()
    {
        $this->serv=new \swoole_server("0.0.0.0",9510);
        $this->serv->set(array(
            'worker_num' => 8,
            'daemonize' => false,
            'max_request' => 10000,
            'dispatch_mode' => 2,
            'debug_mode'=> 1
        ));
        $this->swoole_handle = App::make('swoole');
        //$this->serv->on('Start', array($this->swoole_handle, 'onStart'));
        //$this->serv->on('Connect', array($this->swoole_handle, 'onConnect'));
        $this->serv->on('Receive', array($this->swoole_handle, 'onReceive'));
        //$this->serv->on('Close', array($this->swoole_handle, 'onClose'));
        $this->serv->start();
    }
}
