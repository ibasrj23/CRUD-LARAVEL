<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicPostController; // <--- Dependency baru
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostnewController;


// Route::get('/example', function () {
//  return 'This is an example route';
// });

// Route::get('/example2', function () {
//  return 'This is another example route';
// });

// Route::get('/example2', [App\Http\Controllers\ExampleController::class, 'index']);


Route::get('/example2/{id}', [App\Http\Controllers\ExampleController::class, 'index']);

// Route::get('/users',[
//  App\Http\Controllers\UserController::class,'index'
// ]);

Route::get('/posts', [
    App\Http\Controllers\PostController::class,
    'index'
]);

Route::resource('posts', App\Http\Controllers\PostController::class); //otomatis pake semua route CRUD

//menentukan nilai ganjil genap di route
Route::get('/ganjil/{number}', function ($number) {
    if ($number % 2 == 0) {
        dd("$number adalah bilangan genap");
    } else {
        dd("$number adalah bilangan ganjil");
    }
});

// ===================================
// START: ROUTE PUBLIK (Tidak perlu login)
// ===================================

Route::get('/public/posts', [PublicPostController::class, 'index'])->name('posts.public.index');
// Menggunakan Route Model Binding untuk Post (membutuhkan model Post)
Route::get('/public/posts/{post}', [PublicPostController::class, 'show'])->name('posts.public.show');

// ===================================
// END: ROUTE PUBLIK
// ===================================


Route::group([
    'middleware' => ['auth'],
], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::group([
        'middleware' => ['Admin'],
    ], function () {
        Route::resource('users', App\Http\Controllers\UserController::class);
    });
});




//NEW POST MAS IVAN NO UI

Route::get('/newposts', [
    App\Http\Controllers\PostnewController::class,
    'index'
]);

Route::get('/newposts/create', [
    App\Http\Controllers\PostnewController::class,
    'create'
]);

Route::get('/newposts/{id}', [
    App\Http\Controllers\PostnewController::class,
    'show'
]);

Route::get('/newposts/{id}/update', [
    App\Http\Controllers\PostnewController::class,
    'update'
]);

Route::get('/newposts/{id}/delete', [
    App\Http\Controllers\PostnewController::class,
    'destroy'
]);

require __DIR__ . '/auth.php';