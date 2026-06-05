<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:global'])->group(function () {
    
Route::get('/', function () {
    return redirect('/home');
});

Route::get('/login', function(){

    return response()->file(public_path('index.html'));
})->name('login');

Route::get('/register', function(){

    return file_get_contents(public_path('index.html'));
});

Route::get('/home', function(){

    return file_get_contents(public_path('index.html'));
});

Route::get('/topic/{name}', function(){

    return file_get_contents(public_path('index.html'));
});

Route::get('/topic/{name}/post/create', function(){

    return file_get_contents(public_path('index.html'));
})->middleware('auth');

Route::get('/post/{id}', function(){

    return file_get_contents(public_path('index.html'));
});

});