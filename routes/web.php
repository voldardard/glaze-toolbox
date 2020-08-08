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


            return view('insert')->with('Params', $Params);
        })->name('insert');
        Route::post('/insert', 'recipes\Insert');
        Route::get('/categories', function () {
            session(['current_route' => '/categories']);
            return view('categories');
        })->name('categories');
        Route::get('/category/{parentID?}', 'recipes\Categories@getCategory')->where(['parentID' => '[A-Za-z0-9]+']);
        Route::get('/raw', 'recipes\Categories@getRaw');
        Route::get('/lands', 'recipes\Categories@getLand');


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

