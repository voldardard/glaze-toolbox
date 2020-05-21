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
    public function __invoke(Request $request){
        print_r($_FILES);
        if (isset($_FILES['files'])) {
            $errors = [];
            $uri=[];
            $path = public_path().'tmp/';
            $extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $file_size_limit=2097152;
            $file_sha=time().sha1(time()).'_';

            $all_files = count($_FILES['files']['tmp_name']);

            for ($i = 0; $i < $all_files; $i++) {
                $file_name = $_FILES['files']['name'][$i];
                $file_tmp = $_FILES['files']['tmp_name'][$i];
                $file_type = $_FILES['files']['type'][$i];
                $file_size = $_FILES['files']['size'][$i];
                $file_ext = strtolower(end(explode('.', $_FILES['files']['name'][$i])));

                $file = $path . $file_sha.$file_name;

                if (!in_array($file_ext, $extensions)) {
                    $errors[] = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
                }

                if ($file_size > $file_size_limit) {
                    $errors[] = 'File size exceeds limit ('.$file_size_limit.'): ' . $file_name . ' ' . $file_type. ' ('.$file_size.')';
                }

                if (empty($errors)) {
                    move_uploaded_file($file_tmp, $file);
                    $uri[]=url('tmp/'.$file_sha.$file_name);
                }
            }

            if ($errors){
                return response($errors, 415);
            }else{
                return response($uri, 200);
            }
        }else{
            return response('No content', 204)->header('Content-Type', 'text/plain');
        }
    }
}