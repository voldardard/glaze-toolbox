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


Route::group(['prefix' => Config::get('app.locale')], function () {
    //authenticated route
    Route::middleware("auth.classic")->group(function () {
        Route::get('/', function () {
            dd(session()->all());
            return view('welcome');
        })->name('home');
    });

    Route::get('/login', function () {
        $back_url = url()->previous();
        if (strpos($back_url, 'logout') !== false) {
            $back_url = Config::get('app.url')."/".Config::get('app.locale');
        }
        session(['link' => url()->previous()]);
        dd(session()->all());
        return view('login');
    })->name('login');
    Route::post('/login', 'auth\Login');

    Route::get('/register', function () {
        return view('register');
    })->name('register');
    Route::post('/register', 'auth\Register');
    Route::get('/logout', 'auth\Login@logout')->name('logout');

});

