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
use Illuminate\Support\Facades\Storage;


class Upload extends Controller{
    public function __invoke(Request $request)
    {

        $request->validate([
            'pic.*' => 'required|mimes:jpg,jpeg,png,bmp|max:20000',
        ]);

        $files = $request->file('pic');

        $url=[];
        foreach ($files as $file){
            $file_name=time().'_'.sha1($file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();
            Storage::disk('tmp')->put($file_name, file_get_contents($file));
            //$url[]=Storage::disk('tmp')->url($file_name);
            $url[]="/tmp/".$file_name;
        };

        return response($url, 200);


    }

}