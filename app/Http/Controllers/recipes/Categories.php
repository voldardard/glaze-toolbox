<?php

namespace App\Http\Controllers\recipes;

use http\Env\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
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
    public function getCategory($parentID=null){
        if (is_null($parentID)) {
            $categories = DB::table('categories')->select(['id', 'name'])->whereNull('parent_id')->get();

        } else {
            $categories = DB::table('categories')->select(['id', 'name'])->where('parent_id', $parentID)->get();
        }
        return response()->json($categories);


    }

    public function buildView($recipeID)
    {
        $view = new \stdClass();

        try {
            $decryptedID = Crypt::decryptString($recipeID);
        } catch (DecryptException $e) {
            abort('404');
        }


        if (DB::table('recipes')->where(['id' => $decryptedID])->exists()) {
            $recipe = DB::table('recipes')->select(['id', 'name', 'users_id', 'parent_id', 'version'])->where(['id' => $decryptedID])->first();
        } else {
            abort('404');
        }
        $view->id = $recipe->id;
        $view->name = $recipe->name;
        $view->version = $recipe->version;
        $view->parent = Crypt::encryptString($recipe->parent_id);
        $view->components = array();
        $view->creator = DB::table('users')->select(['name', 'fsname', 'username', 'email'])->where(['id' => $value->raw_id])->first();


        $components = DB::table('recipe_components')->select(['quantity', 'extra', 'raw_id'])->where(['recipes_id' => $decryptedID])->get();
        foreach ($components as $key => $value) {
            $raw_materials = DB::table('raw_materials')->select(['name', 'formula'])->where(['id' => $value->raw_id])->first();
            $raw = new \stdClass();
            $raw->name = $raw_materials->name;
            $raw->formula = $raw_materials->formula;
            $raw->name = $value->quantity;
            $raw->extra = $value->extra;

            $view->components[] = $raw;
        }


        print_r($view);

    }

    public function getRaw()
    {
        $raw = DB::table('raw_materials')->select(['id', 'name', 'formula'])->where(['locale' => Config::get('app.locale')])->get();
        return response()->json($raw);

    }

    public function getLand()
    {
        $land = DB::table('lands')->distinct()->select(['name'])->groupBy('name')->where(['locale' => Config::get('app.locale')])->get();
        return response()->json($land);

    }

    public function getAuthor($typeID = null)
    {
        if (is_null($typeID)) {
            $author = DB::table('sources')->distinct()->select(['author as name'])->groupBy('author')->get();
        } else {
            $author = DB::table('sources')->distinct()->select(['author as name'])->where(['type_id' => $typeID])->groupBy('author')->get();
        }
        return response()->json($author);
    }

    public function getType()
    {
        $type = DB::table('sources_types')->distinct()->select(['id', 'name'])->groupBy('name', 'id')->where(['locale' => Config::get('app.locale')])->get();
        return response()->json($type);
    }

    public function getAllCategories()
    {
        $category = \DB::select('SELECT category_name as name, category_id as id, fk_category_id as parent FROM `TB_Category` WHERE category_dlDate IS NULL');
        foreach ($category as $key => $value) {
            $category[$key]->name = self::getTranslation($value->name);
        }
        $arr = json_decode(json_encode($category), true);

        $new = array();
        foreach ($arr as $a) {

            $new[$a['parent']][] = $a;
        }
        $parent=($new[NULL]);
        $data = self::createaTree($new, $parent);
        return $data;
    }


}