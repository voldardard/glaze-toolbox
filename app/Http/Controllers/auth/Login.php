<?php

namespace App\Http\Controllers\auth;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;



class Login extends Controller{

    public function __invoke(Request $request){
        $validatedData = $request->validate([
            'user' => 'required|string',
            'password' => 'required|string',
        ]);

        if(! self::test_connection($request->input('user'), $request->input('password'))){
            return Redirect::back()->withError( "Username or password missmatch")->withInput();
        }
        return Redirect::to(route('action'));
    }
    private function test_connection($login, $password){
        $rounds=(int)(count_chars($login.env('ROUNDS').$password)/2);
        $hashedpassword =Hash::make(env('SALT1').$password.env('SALT2'), ['rounds' => $rounds]);

        if(DB::table('users')->where(['username'=>$login, 'password'=>$hashedpassword])->exists()){
            self::store_data($login);

            return true;
        }else{
            return false;
        }
    }
    private function store_data($login){
        $user = DB::table('users')->where('username', $login)->first();

        session(["name"=>$user->name, "fsname"=>$user->fsname, "username"=>$user->username, "id"=>$user->id, "email"=>$user->email]);

    }
    public function logout(Request $request){
        $request->session()->flush();
        $request->session()->regenerate();
        Cookie::forget('token');
        return Redirect::to(route('login'))->withError( "You've been disconnected" )->withInput();

    }
}
