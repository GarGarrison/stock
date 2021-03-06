<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\User;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function username(){
        return 'name';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login() {
        $name = Input::get('name');
        $passwd = Input::get('passwd');
        $user = User::whereLogin($name)->first();
        // \Log::info("orig:".$user->passwd);
        // \Log::info("fact:".sha1($passwd));
        if ($user && $user->passwd == sha1($passwd)) { 
            Auth::login($user, true);
            return redirect()->intended('/');
        }
        else return redirect()->back()->withErrors(['passwd'=> 'Неверный логин или пароль']);
    }
}
