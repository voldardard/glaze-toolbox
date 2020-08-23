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
use Lang;
use Config;
use App;



class Login extends Controller{
    private $message;

    public function __invoke(Request $request){
        $validatedData = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!self::test_connection($validatedData['username'], $validatedData['password'])) {
            return Redirect::back()->withError($this->message)->withInput();
        }
        if (!empty(session()->get('backurl'))) {
            return redirect(session()->get('backurl'));
        } elseif (!empty(session()->get('link'))) {
            return redirect(session()->get('link'));
        } else {
            return redirect(App::getLocale());
        }
    }
    private function test_connection($login, $password){
        //user exist
        if(DB::table('users')->where(['username'=>$login])->exists()){
            $user =DB::table('users')->select("name", "fsname", "username", "id", "email", "admin", "password", "enable", "locale")->where('username', $login)->first();

            if($user->enable==false){
                $this->message=Lang::get('login.l-017-account_disable');
                return false;
            }
            if (in_array($user->locale, array_keys(Config::get('app.availables_locale')))){
                App::setLocale($user->locale);
            }

            if(! Hash::check(env('SALT1').$password.env('SALT2'), $user->password)){
                //password missmatch
                $this->message = Lang::get('login.l-007-usernameorpasswordmissmatch');
                return false;
            }
            session([
                "username" => $user->username,
                "name" => $user->name,
                "fsname" => $user->fsname,
                "id" => $user->id,
                "email" => $user->email,
                "admin" => $user->admin,
                "login" => now(),
            ]);
            App::setLocale($user->locale);

            return true;

        }else{
            //user missmatch
            $this->message = Lang::get('login.l-007-usernameorpasswordmissmatch');
            return false;
        }
    }

    public function logout(Request $request){
        $request->session()->flush();
        $request->session()->regenerate();
        return Redirect::to(route('login'))->with('success', Lang::get('login.l-008-disconnectSuccess'));

    }
}
