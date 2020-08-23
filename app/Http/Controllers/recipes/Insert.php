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
            'pictures.*' => 'string|nullable',
            'raw.*.name' => 'string|required|max:45',
            'raw.*.quantity' => 'integer|required',
            'raw.*.formula' => 'string|max:45|nullable',
            'raw-extra.*.name' => 'string|required|max:45',
            'raw-extra.*.quantity' => 'integer|required',
            'raw-extra.*.formula' => 'string|max:45|nullable',
            'land' => 'string|required|max:45',
            'bake.orton' => 'integer|required',
            'bake.oven' => 'string|required|max:45',
            'bake.type' => 'string|nullable|max:45',
            'bake.temp' => 'integer|required',
            'remarks' => 'string|nullable',
            'sources.*.name' => 'string|required|max:45',
            'sources.*.year' => 'integer|min:1700|max:2100',
            'sources.*.type' => 'string|required|max:45',
            'sources.*.author' => 'string|required|max:45',
            'sources.*.description' => 'string|nullable',


        ]);
        $total = 0;
        foreach ($validatedData['raw'] as $value) {
            $total += $value['quantity'];
        }
        if ($total != 100)
            return Redirect::back()->withError('total raw material not egal to 100')->withInput();


        //insert categories
        $mayExist = true;
        $parent_id = null;
        foreach ($validatedData['category'] as $key => $value) {
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
                    'parent_id' => $parent_id,
                    'name' => $value,
                    'level' => $key,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'delete' => false
                ]);
            }

        }

        //insert in recipes table
        $recipeID = DB::table('recipes')->insertGetId([
            'name' => $validatedData['title'],
            'version' => '1.0.0',
            'users_id' => session()->get('id'),
            'categories_id' => $parent_id,
            'locale' => Config::get('app.locale'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        //save preload pictures
        if (!empty($validatedData['pictures'])) {
            foreach ($validatedData['pictures'] as $key => $value) {
                $exploded = explode('/', $key);
                $filename = str_replace('::', '.', $exploded[count($exploded) - 1]);

                if (empty($value)) {
                    $exploded = explode('.', $filename);
                    $name = $exploded[0];
                } else {
                    $name = $value;
                }
                Storage::disk('local')->move('tmp/' . $filename, 'pictures/' . $filename);
                $url = "/pictures/" . $filename;
                DB::table('pictures')->insert([
                    'path' => $url,
                    'name' => $name,
                    'recipes_id' => $recipeID,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted' => false
                ]);
            }
        }

        //store new pictures
        if(!empty($validatedData['pic'])) {

            $files = $request->file('pic');

            foreach ($files as $file) {
                $filename = time() . '_' . sha1($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                $url = "/pictures/" . $filename;
                $exploded = explode('.', $filename);
                $name = $exploded[0];

                Storage::disk('pictures')->put($filename, file_get_contents($file));

                DB::table('pictures')->insert([
                    'path' => $url,
                    'name' => $name,
                    'recipes_id' => $recipeID,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted' => false
                ]);
            };
        }


        //store labels
        if(!empty($validatedData['label'])) {

            foreach ($validatedData['label'] as $key => $value) {

                if (!empty($value)) {
                    if (DB::table('labels')->where(['name' => $value, 'locale' => Config::get('app.locale')])->exists()) {
                        $label_id = DB::table('labels')->select('id')->where(['name' => $value])->first()->id;
                    } else {
                        $label_id = DB::table('labels')->insertGetId([
                            'name' => $value,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                    DB::table('recipe_labels')->insert([
                        'labels_id' => $label_id,
                        'recipes_id' => $recipeID,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        if (!empty($validatedData['raw'])) {

            foreach ($validatedData['raw'] as $key => $value) {

                if (!DB::table('raw_materials')->where(['name' => $value['name'], 'formula' => $value['formula'], 'locale' => Config::get('app.locale')])->exists()) {
                    $raw_id = DB::table('raw_materials')->insertGetId([
                        'name' => $value['name'],
                        'formula' => $value['formula'],
                        'locale' => Config::get('app.locale'),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } else {
                    $raw_id = DB::table('raw_materials')->select('id')->where(['name' => $value['name'], 'formula' => $value['formula'], 'locale' => Config::get('app.locale')])->first()->id;
                }

                DB::table('recipe_components')->insert([
                    'quantity' => $value['quantity'],
                    'raw_id' => $raw_id,
                    'recipes_id' => $recipeID,
                    'created_at' => now(),
                    'extra' => false,
                    'updated_at' => now()
                ]);


            }
        }
        if (!empty($validatedData['raw-extra'])) {

            foreach ($validatedData['raw-extra'] as $key => $value) {

                if (!DB::table('raw_materials')->where(['name' => $value['name'], 'formula' => $value['formula'], 'locale' => Config::get('app.locale')])->exists()) {
                    $raw_id = DB::table('raw_materials')->insertGetId([
                        'name' => $value['name'],
                        'formula' => $value['formula'],
                        'locale' => Config::get('app.locale'),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } else {
                    $raw_id = DB::table('raw_materials')->select('id')->where(['name' => $value['name'], 'formula' => $value['formula'], 'locale' => Config::get('app.locale')])->first()->id;
                }

                DB::table('recipe_components')->insert([
                    'quantity' => $value['quantity'],
                    'raw_id' => $raw_id,
                    'recipes_id' => $recipeID,
                    'extra' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);


            }
        }
        if (!empty($validatedData['land'])) {
            DB::table('lands')->insert([
                'name' => $validatedData['land'],
                'recipes_id' => $recipeID,
                'created_at' => now(),
                'updated_at' => now(),
                'locale' => Config::get('app.locale'),

            ]);
        }
        if (!empty($validatedData['bake'])) {
            DB::table('baking')->insert([
                'oven' => $validatedData['bake']['oven'],
                'orton' => $validatedData['bake']['orton'],
                'temperature' => $validatedData['bake']['temp'],
                'type' => $validatedData['bake']['type'],
                'recipes_id' => $recipeID,
                'created_at' => now(),
                'updated_at' => now(),

            ]);
        }
        if (!empty($validatedData['remarks'])) {
            DB::table('remarks')->insert([
                'text' => $validatedData['remarks'],
                'locale' => Config::get('app.locale'),
                'recipes_id' => $recipeID,
                'created_at' => now(),
                'updated_at' => now(),

            ]);
        }
        if (!empty($validatedData['sources'])) {

            foreach ($validatedData['sources'] as $key => $value) {

                if (!DB::table('sources_types')->where(['name' => $value['type'], 'locale' => Config::get('app.locale')])->exists()) {
                    $source_type_id = DB::table('sources_types')->insertGetId([
                        'name' => $value['type'],
                        'locale' => Config::get('app.locale'),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } else {
                    $source_type_id = DB::table('sources_types')->select('id')->where(['name' => $value['type'], 'locale' => Config::get('app.locale')])->first()->id;
                }

                DB::table('sources')->insert([
                    'name' => $value['name'],
                    'author' => $value['author'],
                    'description' => $value['description'],
                    'type_id' => $source_type_id,
                    'recipes_id' => $recipeID,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);


            }
        }

        print_r(Crypt::encryptString($recipeID));
        return Redirect::to(route('view', ['recipeID' => Crypt::encryptString($recipeID)]));


    }

}