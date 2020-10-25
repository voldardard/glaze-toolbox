<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Get the language requested
$locale = \Request::segment(1);


if (in_array($locale, array_keys(Config::get('app.availables_locale')))){
    App::setLocale($locale);
}

Route::get('/logout', 'auth\Login@logout')->name('logout-classic');


Route::get('/', function () {
    return Redirect::to(\route('home'));
})->middleware('auth.classic');;


Route::post('/upload', 'tools\Upload')->middleware('auth.classic');
//Route::post('/upload', 'tools\Upload');


Route::group(['prefix' => Config::get('app.locale')], function () {
    //authenticated route
    Route::middleware("auth.classic")->group(function () {
        Route::get('/', function () {
            session(['current_route'=>'/']);
            return view('home');
        })->name('home');
        Route::get('/insert', function () {
            session(['current_route' => '/insert']);
            $Controller = new \App\Http\Controllers\recipes\Categories();
            $Params = new \stdClass();
            $Params->raw = $Controller->getRaw()->content();
            $Params->categories = $Controller->getCategory()->content();
            $Params->lands = $Controller->getLand()->content();
            $Params->labels = $Controller->getLabels()->content();
            $Params->sources_type = $Controller->getType()->content();
            $Params->sources_author = $Controller->getAuthor()->content();

            return view('insert')->with('Params', $Params);
        })->name('insert');
        Route::get('/view/{recipeID}', function ($recipeID) {
            session(['current_route' => '/view']);
            $Controller = new \App\Http\Controllers\recipes\Categories();
            $Params = json_decode($Controller->buildView($recipeID)->content());
            return view('view')->with('Params', $Params);
        })->where(['recipeID' => '[a-zA-Z0-9]+'])->name('view');

        Route::post('/insert', 'recipes\Insert');

        Route::get('/categories', function () {
            session(['current_route' => '/categories']);
            $Controller = new \App\Http\Controllers\recipes\Categories();
            $Params = new \stdClass();
            $Params->categories = json_decode($Controller->getAllCategories()->content(), true);
            return view('categories')->with('Params', $Params);
        })->name('categories');

        Route::get('/category/{categoryID}', function ($categoryID) {
            session(['current_route' => '/categories']);
            $Controller = new \App\Http\Controllers\recipes\Categories();
            $Params = new \stdClass();
            $Params->recipes = json_decode($Controller->getCategoryProducts($categoryID)->content(), true);
            return view('category')->with('Params', $Params);
        })->where(['categoryID' => '[a-zA-Z0-9]+'])->name('getCategory');
        Route::put('/category', 'recipes\Categories@insertCategory')->middleware('merge.json');
        Route::delete('/category/{categoryID}', 'recipes\Categories@deleteCategory')->where(['categoryID' => '[a-zA-Z0-9]+'])->middleware('merge.json');
        Route::patch('/category/{categoryID}', 'recipes\Categories@editCategory')->where(['categoryID' => '[a-zA-Z0-9]+'])->middleware('merge.json');




        Route::group(['prefix' => 'autocomplete'], function () {
          Route::get('/categories', 'recipes\Categories@getAllCategories');
            Route::get('/category/{parentID?}', 'recipes\Categories@getCategory')->where(['parentID' => '[0-9]+']);
            Route::get('/raw', 'recipes\Categories@getRaw');
            Route::get('/lands', 'recipes\Categories@getLand');
            Route::get('/labels', 'recipes\Categories@getLabels');
            Route::get('/sources/type', 'recipes\Categories@getType');
            Route::get('/sources/author', 'recipes\Categories@getAuthor');
            Route::get('/sources/author/type/{typeID?}', 'recipes\Categories@getAuthor')->where(['typeID' => '[0-9]+']);
            Route::get('/jsonview/{recipeID}', 'recipes\Categories@buildView')->where(['recipeID' => '[a-zA-Z0-9]+']);
        });

    });

    Route::get('/login', function () {

        $back_url = url()->previous();
        if ( (strpos($back_url, 'logout') !== false) OR (strpos($back_url, 'login') !== false) ) {
            $back_url = route('home');
        }
        session(['link' => $back_url, 'current_route'=>'/login']);
        return view('login');
    })->name('login');
    Route::post('/login', 'auth\Login');

    Route::get('/register', function () {
        session(['current_route'=>'/register']);
        return view('register');
    })->name('register');
    Route::post('/register', 'auth\Register');
    Route::get('/logout', 'auth\Login@logout')->name('logout');

});
