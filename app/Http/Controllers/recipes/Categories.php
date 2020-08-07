<?php

namespace App\Http\Controllers\recipes;

//use http\Env\Response;
use http\Client\Response;
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



class Categories extends Controller{
    public function getCategory(Request $input, $parentID=null){
    if (is_null($parentID)){
        $categories = DB::table('categories')->select(['id', 'name'])->whereNull('parent_id')->get();

    }else {
        echo $parentID;
        $categories = DB::table('categories')->select(['id', 'name'])->where('parent_id', $parentID)->get();
    }
    return Response::json($categories);


    }
    public function getAllCategories(){
        $category = \DB::select('SELECT category_name as name, category_id as id, fk_category_id as parent FROM `TB_Category` WHERE category_dlDate IS NULL');
        foreach ($category as $key=>$value){
            $category[$key]->name=self::getTranslation($value->name);
        }
        $arr=json_decode(json_encode($category), true);

        $new = array();
        foreach ($arr as $a){

            $new[$a['parent']][] = $a;
        }
        $parent=($new[NULL]);
        $data = self::createaTree($new, $parent);
        return $data;
    }


}