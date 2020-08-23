<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Get the language requested
$locale = \Request::segment(2);


if (in_array($locale, array_keys(Config::get('app.availables_locale')))) {
    App::setLocale($locale);
}

Route::group(['prefix' => Config::get('app.locale')], function () {
    //authenticated route
    Route::middleware("auth.classic")->group(function () {
        Route::get('/category/{parentID?}', 'recipes\Categories@getCategory')->where(['parentID' => '[0-9]+']);
        Route::get('/raw', 'recipes\Categories@getRaw');
        Route::get('/lands', 'recipes\Categories@getLand');
        Route::get('/sources/type', 'recipes\Categories@getType');
        Route::get('/sources/author', 'recipes\Categories@getAuthor');
        Route::get('/sources/author/type/{typeID?}', 'recipes\Categories@getAuthor')->where(['typeID' => '[0-9]+']);
        Route::get('/jsonview/{recipeID}', 'recipes\Categories@buildView')->where(['recipeID' => '[a-zA-Z0-9]+']);

    });
});
