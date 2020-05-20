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

class auth
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
            'name' => 'required|string',
            'fsname' => 'required|string',
            'email' => 'required|email|max:60',
        ]);

        if ($validator->fails()) {
            return Redirect::to(route('login'));
        }

        return $next($request);
    }
}
