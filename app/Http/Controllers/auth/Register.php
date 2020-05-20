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
use Log;



class Register extends Controller{

    public function __invoke(Request $request){
        $validatedData = $request->validate([
            'username' => 'required|string|max:45',
            'name' => 'required|string',
            'fsname' => 'required|string',
            'email' => 'required|email|max:60',
            'password' => 'required|string',
        ]);
        $rounds=(int)(strlen($validatedData['username'].env('ROUNDS').$validatedData['password'])/2);
        $hashedpassword =Hash::make(env('SALT1').$validatedData['password'].env('SALT2'), ['rounds' => $rounds]);

        //DB::beginTransaction();
        try {
            print_r($validatedData);
            DB::table('users')->insert([
                "username" => $validatedData['username'],
                "name" => $validatedData['name'],
                "fsname" => $validatedData['fsname'],
                "email" => $validatedData['email'],
                "password" => $hashedpassword,
                "created_at" => now(),
                "updated_at" => now()
            ]);
            print_r('enregistré: ');
        }catch (\Exception $e) {
            DB::rollback();
            Log::info($e);
            print_r($e);
            die();
            return Redirect::back()->withError( Lang::get('login.l-016-emailorusernameAlreadyInUse'))->withInput();
        }
        session(DB::table('users')->select("name", "fsname", "username", "id", "email", "admin")->where('username', $validatedData['username'])->first());

        return Redirect::to(route('home'));


    }
}