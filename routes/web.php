<?php

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
use App\Models\User;

Route::get('/', array(
    'as' => '/',
    'uses' => 'App\Http\Controllers\HomeController@index'
));

Auth::routes();

Route::get('/', array(
    'uses' => 'App\Http\Controllers\HomeController@index'
))->name('home');

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

Route::get('/video/{video_id}', array(
    'as' => 'detailVideo',
    'uses' => 'App\Http\Controllers\VideoController@getVideoDetail'
));

Route::get('/video-file/{filename}', array(
    'uses' => 'App\Http\Controllers\VideoController@getVideo'
))->name('fileVideo');

//Comentarios
Route::post('/comment', [
    'middleware' => 'auth',
    'uses' => 'App\Http\Controllers\CommentController@store'
])->name('comment');

//Eliminar comentario
Route::get('/delete-comment/{comment_id}', array(
    'middleware' => 'auth',
    'uses' => 'App\Http\Controllers\CommentController@delete'
))->name('commentDelete');

//Eliminar video
Route::get('/delete-video/{video_id}', array(
    'middleware' => 'auth',
    'uses' => 'App\Http\Controllers\VideoController@delete'
))->name('videoDelete');

//Editar video
Route::get('/editar-video/{video_id}', array(
    'middleware' => 'auth',
    'uses' => 'App\Http\Controllers\VideoController@edit'
))->name('videoEdit');

//Actualizar video
Route::post('/update-video/{video_id}', array(
    'middleware' => 'auth',
    'uses' => 'App\Http\Controllers\VideoController@update'
))->name('updateVideo');

// Buscar video
Route::get('/buscar/{search?}/{filter?}', [
    'uses' => 'App\Http\Controllers\VideoController@search'
])->name('videoSearch');

// Limpiar caché de Laravel
Route::get('clear-cache', function(){
    $code = Artisan::call('cache:clear');
});

/* USERS */
Route::get('/canal/{user_id}', [
    'uses' => 'App\Http\Controllers\UserController@channel'
])->name('channel');