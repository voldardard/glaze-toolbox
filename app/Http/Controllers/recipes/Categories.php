<?php

namespace App\Http\Controllers\recipes;

use http\Env\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Lang;
use Config;
use App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;



class Categories extends Controller{
    public function getCategory($parentID=null){
        if (is_null($parentID)) {
            $categories = DB::table('categories')->select(['id', 'name'])->whereNull('parent_id')->get();

        } else {
            $categories = DB::table('categories')->select(['id', 'name'])->where('parent_id', $parentID)->get();
        }
        return response()->json($categories);


    }

    public function createCategoriesTree($catId, $child = array())
    {
        $category = DB::table('categories')->select(['id', 'name', 'parent_id', 'level'])->where(['id' => $catId])->first();
        $child[$category->level] = $category;
        if ($category->level > 0) {
            $child = $this->createCategoriesTree($category->parent_id, $child);
        }
        return $child;
    }
    private function update_level_recurse($parent_id, $parent_level){
       $categories = DB::table('categories')->select(['id', 'name', 'parent_id', 'level'])->where(['parent_id' => $parent_id])->get();
       foreach ($categories as $key => $value) {
         try {
           DB::table('categories')->where('id',  $value->id)->update([
             'level'=>($parent_level+1),
             'updated_at'=>now()
           ]);
         } catch (\Throwable $e) {
           Log::error($e);
            Log::error("Error when updating category id: ".$value->id);
             Throw $e;
         }
         self::update_level_recurse($value->id, ($parent_level+1));
       }
    }
    private function getCategoryBelow($categoryID){
      $category=array();

      $categories = DB::table('categories')->select(['id', 'name', 'parent_id', 'level'])->where(['parent_id' => $categoryID])->get();
      foreach ($categories as $key => $value) {
        $category[]=$value->id;
        $array =self::getCategoryBelow($value->id);
        $category = array_merge($array, $category);
      }
      return $category;

    }
    public function getCategoryProducts($categoryID){
      if (DB::table('categories')->where(['id' => $categoryID])->exists()) {
        $allCatIdBelow=self::getCategoryBelow($categoryID);
        $recipes=DB::table('recipes')->select('id', 'name', 'version', 'users_id', 'locale')->whereIn('parent_id', $allCatIdBelow)->get();
        $recipes=(array)$recipes;
        print_r($recipes);
        die;
        foreach ($recipes as $key => $value) {
          //$user=DB::table('users')->select('name', 'fsname')->where('id', $value['id'])->get();
          $recipes[$key]->{"name"}=$user->name;
          $recipes[$key]->{"fsname"}=$user->fsname;
        }
        return response()->json(['message'=>$recipes]);


      }else{
        return response()->json(['message'=>"Category does not exist"], 400);
      }
    }
    public function deleteCategory(Request $request, $categoryID){
      if (DB::table('categories')->where(['id' => $categoryID])->exists()) {
        $recipe=array();
        $allCatIdBelow=self::getCategoryBelow($categoryID);
        $recipes=DB::table('recipes')->select('id')->whereIn('parent_id', $allCatIdBelow)->get();
        foreach ($recipes as $key => $value) {
          $recipe[]=$value->id;
        }

        $nrOfDependant= (count($allCatIdBelow)+count($recipe));
        if ($nrOfDependant == 0){
          DB::beginTransaction();

          try {
            DB::table('categories')->where('id',  $categoryID)->delete();
            DB::commit();
          } catch (\Throwable $e) {
              Log::info("Rollback !");
              DB::rollback();
              Log::error($e);
              return response()->json(['message'=>$e], 400);
          }
          return response()->json(['message'=>"Category deleted successfully"]);
        }else{
          $answer=array();
          if(count($recipe)>0){
            $answer[]="There is ".count($recipe)." recipe(s) dependant on this category";
          }
          if(count($allCatIdBelow)>0){
            $answer[]="There is ".count($allCatIdBelow)." category(ies) dependant on this category";
          }
          return response()->json(['message'=>"Cannot delete category", "errors"=>array("name"=>$answer)], 422);

        }

      }else{
        return response()->json(['message'=>"Category does not exist"], 400);
      }
    }
    public function editCategory(Request $request, $categoryID){
      $validatedData = $request->validate([
            'name' => 'string|max:45',
            'parent_id' => 'integer|nullable',
      ]);

      if (DB::table('categories')->where(['id' => $categoryID])->exists()) {

        if( (isset($validatedData['name'])) && (!empty($validatedData['name'])) ){
          DB::table('categories')->where('id',  $categoryID)->update([
            'name'=>$validatedData['name'],
            'updated_at'=>now()
          ]);
          return response()->json(['message'=>"Category name updated successfully"]);
        }
        if( (isset($validatedData['parent_id'])) && (!empty($validatedData['parent_id'])) ){
          $parent = DB::table('categories')->select('level')->where(['id' => $validatedData['parent_id']])->first();
          if(!empty($parent)){
            $level=($parent->level+1);
            $category=DB::table('categories')->select('name')->where(['id' => $categoryID])->first();
            if(DB::table('categories')->where(['name' => $category->name, 'level'=>$level, 'parent_id'=>$validatedData['parent_id']])->exists()){
              return response()->json(['message'=>"Category with same name already exist at this level"], 400);

            }
            DB::beginTransaction();

            try {
              DB::table('categories')->where('id',  $categoryID)->update([
                'parent_id'=>$validatedData['parent_id'],
                'level'=>$level,
                'updated_at'=>now()
              ]);
              self::update_level_recurse($categoryID, $level);
              DB::commit();
            } catch (\Throwable $e) {
                Log::info("Rollback !");
                DB::rollback();
                Log::error($e);
                return response()->json(['message'=>$e], 400);
            }
            return response()->json(['message'=>"Category parent updated successfully"]);

          }else{
            return response()->json(['message'=>"Parent category does not exist does not exist"], 400);
          }
        }elseif (is_null($validatedData['parent_id'])) {
          $level=0;
          $category=DB::table('categories')->select('name')->where(['id' => $categoryID])->first();
          if(DB::table('categories')->where(['name' => $category->name, 'level'=>$level, 'parent_id'=>null])->exists()){
            return response()->json(['message'=>"Category with same name already exist at this level"], 400);

          }
          DB::beginTransaction();

          try {
            DB::table('categories')->where('id',  $categoryID)->update([
              'parent_id'=>null,
              'level'=>$level,
              'updated_at'=>now()
            ]);
            self::update_level_recurse($categoryID, $level);
            DB::commit();
          } catch (\Throwable $e) {
              Log::info("Rollback !");
              DB::rollback();
              Log::error($e);
              return response()->json(['message'=>$e], 400);
          }
          return response()->json(['message'=>"Category parent updated successfully"]);

        }
      }else{
        return response()->json(['message'=>"Category does not exist"], 400);
      }

    }
    public function insertCategory(Request $request){
      $validatedData = $request->validate([
        'name' => 'string|max:45',
        'parent_id' => 'integer|nullable',
      ]);
        if( (isset($validatedData['name'])) && (!empty($validatedData['name']))){
          if( (isset($validatedData['parent_id'])) && (!empty($validatedData['parent_id'])) ){
            $parent = DB::table('categories')->select('level')->where(['id' => $validatedData['parent_id']])->first();
            if(!empty($parent)){
              $level=($parent->level+1);
              if(DB::table('categories')->where(['name' => $validatedData['name'], 'level'=>$level, 'parent_id'=>$validatedData['parent_id']])->exists()){
                return response()->json(['message'=>"Category already exist"], 403);

              }

              DB::beginTransaction();

              try {
                DB::table('categories')->insert([
                  'name'=>$validatedData['name'],
                  'parent_id'=>$validatedData['parent_id'],
                  'level'=>$level,
                  'updated_at'=>now(),
                  'created_at'=>now()

                ]);
                DB::commit();
              } catch (\Throwable $e) {
                  Log::info("Rollback !");
                  DB::rollback();
                  Log::error($e);
                  return response()->json(['message'=>$e], 400);
              }
            }else{
              return response()->json(['message'=>"Parent category does not exist does not exist"], 400);
            }

          }elseif (is_null($validatedData['parent_id'])) {
            $level=0;
            if(DB::table('categories')->where(['name' => $validatedData['name'], 'level'=>$level, 'parent_id'=>null])->exists()){
              return response()->json(['message'=>"Category already exist"], 400);

            }
            DB::beginTransaction();

            try {
              DB::table('categories')->insert([
                'name'=>$validatedData['name'],
                'parent_id'=>null,
                'level'=>$level,
                'updated_at'=>now(),
                'created_at'=>now()

              ]);
              DB::commit();
            } catch (\Throwable $e) {
                Log::info("Rollback !");
                DB::rollback();
                Log::error($e);
                return response()->json(['message'=>$e], 400);
            }
          }else{
            return response()->json(['message'=>"Error with Parent id"+$validatedData['parent_id']], 400);
          }
          return response()->json(['message'=>"Category created successfully"]);

        }else{
          return response()->json(['message'=>"Error with name"], 400);

        }

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
            $recipe = DB::table('recipes')->select(['id', 'name', 'users_id', 'parent_id', 'version', 'categories_id'])->where(['id' => $decryptedID])->first();
        } else {
            abort('404');
        }
        $view->id = $recipe->id;
        $view->crypted_id = $recipeID;
        $view->categories = array_reverse(self::createCategoriesTree($recipe->categories_id), true);
        $view->name = $recipe->name;
        $view->version = $recipe->version;
        $view->creator = DB::table('users')->select(['name', 'fsname', 'username', 'email'])->where(['id' => $recipe->users_id])->first();

        if (!is_null($recipe->parent_id)) {
            $view->parent = Crypt::encryptString($recipe->parent_id);
        }

//        $view->components = array();
        $components = DB::table('recipe_components')->select(['quantity', 'extra', 'raw_id'])->where(['recipes_id' => $decryptedID])->get();
        foreach ($components as $key => $value) {
            $raw_materials = DB::table('raw_materials')->select(['name', 'formula'])->where(['id' => $value->raw_id])->first();
            $raw = new \stdClass();
            $raw->name = $raw_materials->name;
            $raw->formula = $raw_materials->formula;
            $raw->quantity = $value->quantity;
            $raw->extra = $value->extra;

            $view->components[] = $raw;
        }
        $view->baking = DB::table('baking')->select(['orton', 'oven', 'temperature', 'type'])->where(['recipes_id' => $decryptedID])->first();

        //  $view->labels = array();
        $labels_id = DB::table('recipe_labels')->select(['labels_id'])->where(['recipes_id' => $decryptedID])->get();
        foreach ($labels_id as $value) {
            $view->labels[] = DB::table('labels')->select('name')->where(['id' => $value->labels_id])->first()->name;
        }
        if (DB::table('lands')->where(['recipes_id' => $decryptedID])->exists()) {
            $view->land = DB::table('lands')->select(['name',])->where(['recipes_id' => $decryptedID])->first()->name;
        }
        $pictures = DB::table('pictures')->select(['name', 'path'])->where(['recipes_id' => $decryptedID, 'deleted' => false])->get();
        foreach ($pictures as $value) {
            $view->pictures[] = $value;
        }
        if (DB::table('remarks')->select(['text'])->where(['recipes_id' => $decryptedID])->exists()) {
            $view->remark = DB::table('remarks')->select(['text'])->where(['recipes_id' => $decryptedID])->first()->text;
        }

        $sources = DB::table('sources')->select(['name', 'author', 'description', 'type_id'])->where(['recipes_id' => $decryptedID])->get();
        foreach ($sources as $key => $value) {
            $sources_type = DB::table('sources_types')->select(['name'])->where(['id' => $value->type_id])->first();
            $source = new \stdClass();
            $source->type = $sources_type->name;
            $source->name = $value->name;
            $source->author = $value->author;
            $source->description = $value->description;

            $view->sources[] = $source;
        }

        return response()->json($view);


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

    public function getLabels()
    {
        $labels = DB::table('labels')->select(['name'])->get();
        return response()->json($labels);

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
    private function createaTree($parent_id){
      $categories = DB::table('categories')->select(['id', 'name'])->where(['parent_id'=>$parent_id])->get();
      $arr = json_decode(json_encode($categories), true);
      //print_r($arr);
      $data=array();
      //new \stdClass();
      foreach ($arr as $key => $value) {
        $data[$value['id']]= new \stdClass();
        $data[$value['id']]->name=$value['name'];
        $data[$value['id']]->id=$value['id'];
        $data[$value['id']]->childrens = self::createaTree($value['id']);
      }
      return $data;

    }

    public function getAllCategories()
    {

      $categories = DB::table('categories')->select(['id', 'name'])->where(['level'=>0])->get();
      $arr = json_decode(json_encode($categories), true);
      //print_r($arr);
      $data=array();
      //new \stdClass();
      foreach ($arr as $key => $value) {
        $data[$value['id']]= new \stdClass();
        $data[$value['id']]->name=$value['name'];
        $data[$value['id']]->id=$value['id'];
        $data[$value['id']]->childrens = self::createaTree($value['id']);
      }
      return response()->json($data);
    }


}
