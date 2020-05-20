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
use Illuminate\Support\Facades\Hash;
use Lang;s



class Login extends Controller{

    public function __invoke(Request $request){
        $validatedData = $request->validate([
            'user' => 'required|string',
            'password' => 'required|string',
        ]);

        if(! self::test_connection($request->input('user'), $request->input('password'))){
            return Redirect::back()->withError( Lang::get('login.l-007-usernameorpasswordmissmatch'))->withInput();
        }
        return Redirect::to(route('action'));
    }
    private function test_connection($login, $password){
        $rounds=(int)(strlen($login.env('ROUNDS').$password)/2);
        $hashedpassword =Hash::make(env('SALT1').$password.env('SALT2'), ['rounds' => $rounds]);

        if(DB::table('users')->where(['username'=>$login, 'password'=>$hashedpassword])->exists()){
            session(DB::table('users')->select("name", "fsname", "username", "id", "email", "admin")->where('username', $login)->first());
            return true;
        }else{
            return false;
        }
    }

    public function logout(Request $request){
        $request->session()->flush();
        $request->session()->regenerate();
        return Redirect::to(route('login'))->withError(  Lang::get('login.l-008-disconnectSuccess') )->withInput();

    }
}
