<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Gate;

use App\User;
use App\Role;

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

Route::get('/', function(){
    return view('welcome');
});

Route::resources(['notas'=>'NotasController']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/role', 'RoleController')->names('role');//names porque son varios recursos

Route::get('/user/{user}/password','UserController@editContraseña')->name('passwordown.edit');
Route::post('/user/{user}', 'UserController@updateContraseña')->name('passwordown.update');

Route::get('/testdb',function(){
    try{
        DB::connection()->getPdo();
        dd(User::first());
    }catch(\Exception $e){
            die("Coenxion refused error: ".$e);
    }
});


Route::resource('/user','UserController')->names('user');//['except'=>['create','store']] se pueden restringir