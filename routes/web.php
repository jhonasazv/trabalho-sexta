<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TopicoController;
use App\Http\Controllers\UserController;
use App\Models\Post;
use App\Models\Topico;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:global'])->group(function () {


Route::get('/api/home', [Topico::class, 'get']);

Route::get('/api/topico/{nome}', [PostController::class, 'posts']);

Route::get('/api/user', function() {

    $userData = Auth::user();
    if(!$userData){
        return ['erro' => 'não autenticado'];
    }
    $id = $userData->id;
    $apelido = $userData->apelido;
    $img = $userData->img;
    return ['user' => ['id' => $id, 'apelido' => $apelido, 'img' => $img]];
});

/* Route::get('/api/topic/', [PostController::class, 'posts']); */

Route::get('/api/post/{id}', [PostController::class, 'get']);


Route::post('/api/login', [UserController::class, 'login']);

Route::post('/api/logout', [UserController::class, 'logout']);

Route::post('/api/user/delete', [UserController::class, 'delete']);

Route::post('/api/register', [UserController::class, 'register']);

});

Route::middleware(['auth', 'throttle:global'])->group(function (){

    Route::post('/api/topic/{name}/post/create', [PostController::class, 'create']);

    Route::get('/topic/{name}/post/create', function () {
        return file_get_contents(public_path('index.html'));
        });

    Route::delete('/api/post/delete/{id}', [PostController::class, 'delete']);

    Route::post('/api/post/{id}/comment/create/', [ComentarioController::class, 'create']);

    Route::get('/post/{id}/comment/create/', function () {
        return file_get_contents(public_path('index.html'));
        });

    Route::delete('/api/comment/delete/{id}', [ComentarioController::class, 'delete']);

    Route::post('/api/user/update', [UserController::class, 'update']);

});

Route::post('/api/topic/create', [TopicoController::class, 'create']);