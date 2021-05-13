@<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Filesystem\Filesystem;

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

use App\Models\Video;

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', array(
    'as' => 'home',
    'uses' => 'App\Http\Controllers\HomeController@index'
));

//Rutas del controlador de Videos
Route::get('/crear-video', array(
    'as' => 'createVideo',
    'middleware' => 'auth',
    'uses' => 'App\Http\Controllers\VideoController@createVideo'
));

Route::post('/guardar-video', array(
    'as' => 'saveVideo',
    'middleware' => 'auth',
    'uses' => 'App\Http\Controllers\VideoController@saveVideo'
));

Route::get('/miniatura/{filename}', array(
    'as' => 'imageVideo',
    'uses' => 'App\Http\Controllers\VideoController@getImage'
));