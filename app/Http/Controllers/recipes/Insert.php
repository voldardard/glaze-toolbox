<?php

namespace App\Http\Controllers\recipes;

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
            'category.*' => 'required|string|max:45',
            'label.*' => 'string|max:45',
            'pic.*' => 'mimes:jpg,jpeg,png,bmp|max:20000',
            'pictures.*' => 'string|nullable'
        ]);

        //insert in recipes table
        $recipeID= DB::table('recipes')->insertGetId([
            'name'=>$validatedData['title'],
            'version'=>'1.0',
            'users_id'=>session()->get('id'),
            'parent_id'=>null,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);

        //insert categories
        $mayExist=true;
        $parent_id=null;
        foreach($validatedData['category'] as $key => $value) {
            if ($mayExist) {

                if (!DB::table('categories')->where(['name' => $value, 'delete' => 0, 'level' => $key, 'parent_id' => $parent_id])->exists()) {
                    $parent_id=DB::table('categories')->insertGetId([
                        'parent_id'=>$parent_id,
                        'name'=>$value,
                        'level'=>$key,
                        'created_at'=>now(),
                        'updated_at'=>now(),
                        'delete'=>false
                    ]);
                    $mayExist = false;
                }else{
                    $parent_id=DB::table('categories')->select('id')->where(['name' => $value, 'delete' => 0, 'level' => $key, 'parent_id' => $parent_id])->first()->id;
                }
            }else{
                $parent_id=DB::table('categories')->insertGetId([
                    'parent_id'=>$parent_id,
                    'name'=>$value,
                    'level'=>$key,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                    'delete'=>false
                ]);
            }

        }

        print_r($validatedData);
        die();




    }

}