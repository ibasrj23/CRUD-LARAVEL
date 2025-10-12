<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Import Controllers (Pastikan semua Controller ada di sini)
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PublicPostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostnewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExampleController;

/*
|--------------------------------------------------------------------------
| START: ROUTE PUBLIK (Tidak memerlukan login)
|--------------------------------------------------------------------------
*/

// Home/Root Path -> DASHBOARD (Accessible to everyone)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Daftar Post Publik (Sudah benar)
Route::get('/public/posts', [PublicPostController::class, 'index'])->name('posts.public.index');

// Detail Post Publik (Menggunakan {id} untuk menghindari Model Binding)
Route::get('/public/posts/{id}', [PublicPostController::class, 'show'])->name('posts.public.show');

// Route Ganjil Genap (Testing lama)
Route::get('/ganjil/{number}', function ($number) {
    if ($number % 2 == 0) {
        dd("$number adalah bilangan genap");
    } else {
        dd("$number adalah bilangan ganjil");
    }
});


/*
|--------------------------------------------------------------------------
| START: ROUTE AUTHENTICATED (Membutuhkan Login - Middleware 'auth')
|--------------------------------------------------------------------------
*/

Route::group([
    'middleware' => ['auth'],
], function () {

    // ROUTE PROFIL SAYA (Untuk Semua User yang Login)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ROUTE ADMIN (Hanya Role 1)
    Route::group([
        'middleware' => ['Admin'],
    ], function () {
        Route::resource('users', UserController::class);
        Route::resource('posts', PostController::class); // Route Admin CRUD
    });
});


/*
|--------------------------------------------------------------------------
| ROUTE KHUSUS LAINNYA & LOGOUT FIX
|--------------------------------------------------------------------------
*/

// ROUTE LOGOUT OVERRIDE (FIX: Memastikan redirect ke 'login' setelah logout)
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');


// NEW POST MAS IVAN NO UI (Route testing lama)
Route::get('/newposts', [PostnewController::class, 'index']);
Route::get('/newposts/create', [PostnewController::class, 'create']);
Route::get('/newposts/{id}', [PostnewController::class, 'show']);
Route::get('/newposts/{id}/update', [PostnewController::class, 'update']);
Route::get('/newposts/{id}/delete', [PostnewController::class, 'destroy']);


// ROUTE TESTING LAMA
Route::get('/example2/{id}', [ExampleController::class, 'index']);

require __DIR__ . '/auth.php';