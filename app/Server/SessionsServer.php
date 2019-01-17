<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/17
 * Time: 19:46
 */
namespace App\Server;

use App\Http\Controllers\UsersController;
use App\Interfaces\SessionsServerInterface;
use Illuminate\Support\Facades\Auth;


class SessionsServer implements  SessionsServerInterface{

    protected $usersController;
    public function __construct(UsersController $usersController){
        $this->usersController =$usersController;
    }

    /**登陆
     * @param array $credentials
     * @param $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function attempt(array $credentials,$request){
        if (Auth::attempt($credentials, $request->has('remember'))) {
            if(Auth::user()->activated) {
                session()->flash('success', '欢迎回来！');
                $fallback = route('users.show', Auth::user());
                return redirect()->intended($fallback);
            } else {
                $this->usersController->sendEmailConfirmationTo(Auth::user());
                Auth::logout();
                session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/');
            }
        } else {
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
    }

}