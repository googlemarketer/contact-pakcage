<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Googlemarketer\Contact\Http\Controllers'], function(){
    Route::resource('/contact', ContactController::class);
});
