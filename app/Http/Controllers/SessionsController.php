<?php

namespace App\Http\Controllers;


use App\Interfaces\SessionsServerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{

    protected  $sessionsServer;
    public function __construct(SessionsServerInterface $sessionsServer)
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
        $this->sessionsServer =$sessionsServer;
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ],[
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '请输入正确的验证码',
        ]);
        unset($credentials['captcha']);
        return $this->sessionsServer->attempt($credentials,$request);

    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
