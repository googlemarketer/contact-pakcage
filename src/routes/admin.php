<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function(){
//   //All the admin routes will be defined here...
// });

// Route::middleware('web')->domain('admin.'.env('SITE_URL'))->group(function(){
//   Route::resource('adminorders','OrderController');  
// });
Route::namespace('Admin')->name('admin.')->group(function(){
  Route::get('/', 'AdminController@index')->name('home');
  Route::resource('category','CategoryController');
  Route::resource('subcategory','SubcategoryController');
  Route::resource('service','ServiceController');
  Route::resource('subservice','SubserviceController');
  Route::resource('job', 'JobController');
  Route::resource('article','ArticleController');
  Route::resource('project', 'ProjectController');
  Route::resource('project/{project}/task', 'ProjectTaskController');
  Route::resource('project/{project}/comment', 'ProjectCommentController');
  Route::resource('tag','TagController');
  Route::resource('/{admin}/orders','AdminOrderController');   
  Route::resource('{admin}/messages','MessageController');   
  /* Route::resource('orders','OrderController');  
 */
  
  //  All Login Routes goes here
  Route::namespace('Auth')->group(function(){
    //Login Routes
   Route::get('/login','LoginController@showAdmin')->name('login');
   Route::post('/login','LoginController@loginAdmin')->name('login');
 
    //Register Routes
   Route::get('/register','RegisterController@showAdmin')->name('register');
   Route::post('/register','RegisterController@createAdmin')->name('register');
 
    //logout Route
   Route::post('/logout','LoginController@logout')->name('logout');  
 
   //Forgot Password Routes
   Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
   Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');
 
   //Reset Password Routes
   Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
   Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');
 });


});


