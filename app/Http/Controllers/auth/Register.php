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



class Register extends Controller{

    public function __invoke(Request $request){
        $validatedData = $request->validate([
            'user' => 'required|string',
            'name' => 'required|string',
            'fsname' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        return Redirect::to(route('action'));
    }
}