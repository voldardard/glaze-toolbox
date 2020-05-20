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
$locale = Request::segment(2);

if (in_array($locale, array_keys(Config::get('app.availables_locale')))){
    App::setLocale($locale);
}else{
    App::setLocale(Config::get('app.locale'));
}



Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => Config::get('app.locale')], function () {

    Route::get('/', function () {
        echo "test";
        return view('welcome');
    });

});