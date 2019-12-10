<?php

Route::get('/products', 'Http\Controllers\Web\ProductController@index');
Route::get('/products/{product}', 'Http\Controllers\Web\ProductController@show');
Route::post('/cart', 'Http\Controllers\Web\CartController@store');
Route::post('/cart/delete', 'Http\Controllers\Web\CartController@destroy');
Route::get('/checkout', 'Http\Controllers\Web\CheckoutController@show');
Route::post('/checkout', 'Http\Controllers\Web\CheckoutController@store');
Route::get('/thanks', 'Http\Controllers\Web\ThanksController');