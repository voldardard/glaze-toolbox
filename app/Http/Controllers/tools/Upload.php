<?php

namespace App\Http\Controllers\tools;

use GuzzleHttp\Client;
use http\Env\Response;
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



class Upload extends Controller{
    public function __invoke(Request $request)
    {


        $validator = Validator::make($request->all(), ['pic.*' => 'required|mimes:jpg,jpeg,png,bmp|max:20000'], [
            'pic.*.required' => 'Please upload an image',
            'pic.*.mimes' => 'Only jpeg,png and bmp images are allowed',
            'pic.*.max' => 'Sorry! Maximum allowed size for an image is 20MB',
        ]);


        if ($validator->fails()) {
            return response($validator, 415);
        }

        $files = $request->file('file');


        foreach ($files as $file){
            Storage::put($file->getClientOriginalName(), file_get_contents($file));
            Storage::disk('local')->put('')
        };


    }

}