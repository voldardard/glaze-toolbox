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


class Insert extends Controller{
    public function __invoke(Request $request)
    {


        $validatedData = $request->validate([
            'title' => 'required|string|max:45',
            'category' => 'required|string|max:45',
            'label.*' => 'string',
            'pic.*' => 'image',
            'pictures.*' => 'images'
        ]);

        print_r($validatedData);



    }

}