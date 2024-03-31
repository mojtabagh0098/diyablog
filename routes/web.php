<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('dashboard')->middleware(['auth', 'verified'])->group( function () {
    Route::resource('/posts', PostController::class);
    Route::resource('/categories', CategoryController::class);
    Route::resource('/tags', TagController::class);
    Route::resource('/media', MediaController::class);
    Route::resource('/comments', CommentsController::class);
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/users', UserController::class);
});

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/post/{slug}', [FrontendController::class, 'post'])->name('post.single');
    // ->where('slug', '^((?!about|contact-us|search|login).)*$');
Route::get('/category/{slug}', [FrontendController::class, 'category'])->name('category.single');
Route::get('/search', [FrontendController::class, 'search'])->name('search')->where('search', 'required');
Route::get('/contact-us', [FrontendController::class, 'contact'])->name('contact');
Route::get('/about-us', [FrontendController::class, 'about'])->name('about');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
