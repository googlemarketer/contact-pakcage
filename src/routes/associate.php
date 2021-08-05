<?php

use Illuminate\Routing\Route;

/*
|--------------------------------------------------------------------------
| Associate Routes
|--------------------------------------------------------------------------
|
| Here is where you can register associate routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace('Associate')->name('associate.')->group(function(){

  Route::namespace('Auth')->group(function(){
    //Associate Login Routes
    Route::get('/login', 'LoginController@showAssociate')->name('login');
    Route::post('/login', 'LoginController@loginAssociate')->name('login');
    //Associate Register Route
    Route::get('/register', 'RegisterController@showAssociate')->name('register');
    Route::post('/register', 'RegisterController@createAssociate')->name('register');
    //Associate Logout Route
    Route::post('/logout', 'LoginController@logout')->name('logout');
  });

});

Route::namespace('Associate')->name('associate.')->group(function() {
   Route::resource('/{associate}/profile','AssociateProfileController');

});

Route::namespace('Associate')->name('associate.')->group(function() {
   Route::resource('/', 'AssociateController')->only(['index','create']);
   Route::get('/{associate}', 'AssociateController@show')->name('profile');
   Route::get('/{associate}/dashboard', 'DashboardController')->name('dashboard');
   Route::resource('/{associate}/messages', 'MessageController');
});
