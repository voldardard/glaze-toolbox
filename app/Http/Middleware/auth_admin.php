<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Lang;

class auth_admin
{
    private $message;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $validator= Validator::make(session()->all(), [
            'username' => 'required|string|max:45',

        ]);

        if ($validator->fails()) {
            $request->session()->flush();
            $request->session()->regenerate();
            $request->session()->put('backurl', $request->url());
            return Redirect::to(route('login'))->withError(Lang::get('login.l-020-expired'));
        }


        if(! DB::table('users')->where(['username'=>session()->get('username'), 'admin'=>true])->exists()){
            $request->session()->flush();
            $request->session()->regenerate();
            return Redirect::to(route('login'))->withError(Lang::get('login.l-018-unauthorized'));
        }

        return $next($request);
    }
}
