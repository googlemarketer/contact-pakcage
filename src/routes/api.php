<?php

use Illuminate\Http\Request;

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

Route::namespace('Member')->group(function(){

 //Route::apiResource('posts','PostController');
// Route::apiResource('resumes','ResumesController');

});
//Route::get('users/{user}', function (App\User $user) {
 // return $user->email;
//});
//Route::get('posts/{post:slug}', function (App\Models\Member\Post $post) {
 // return $post;
//});
//Route::get('users/{user}/post', function (App\User $user, App\Models\Member\Post $post) {
//  return $user->posts;
//});

//Route::get('users/{user}/post/{post:slug}', function (App\User $user, App\Models\Member\Post $post) {
  //return $post;
//});