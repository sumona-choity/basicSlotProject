<?php

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

// slot route
Route::post('/app/AssignSlot', "HomeController@AssignSlot");
Route::post('/app/booked', "HomeController@booked");
Route::get('/app/showSlot', "HomeController@showSlot");
Route::get('/app/allSlot', "HomeController@allSlot");


Route::get('/logout', function () {
    Auth::logout();
    Session::flush();
    return redirect("/");

});
Route::any('{slug}', 'HomeController@home')->where('slug', '([0-9A-z_\-\s]+)?');