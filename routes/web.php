<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', [UserController::class, 'index'])->name('home');

Route::get('register', [UserController::class, 'create'])->name('create.show');
Route::post('register', [UserController::class, 'store'])->name('create');

Route::get('login', [UserController::class, 'show_login'])->name('login.show');
Route::post('login', [UserController::class, 'login'])->name('login');

Route::post('logout', [UserController::class, 'logout'])->name('logout');

Route::get('/users', [FrontController::class, 'show_users'])->name('users.show');

Route::get('/feed', [FrontController::class, 'show_feed'])->name('feed.show');

Route::get('/post', [PostController::class, 'create'])->name('post.create');
Route::post('/post', [PostController::class, 'store'])->name('post.store');



Route::get('/profile/show/{id}', [UserController::class, 'show'])->name('profile.show');


Route::get('/profile-settings', [UserController::class, 'settings'])->name('profile.settings');

Route::get('/profile-edit', [UserController::class, 'edit'])->name('profile.edit');
Route::put('/profile-edit', [UserController::class, 'update'])->name('profile.update');

Route::post('post/{post_id}/like', [UserController::class, 'like_post'])->name('user.post.like');


Route::put('post/{post_id}/update', [PostController::class, 'update'])->name('post.update');
Route::put('post/{post_id}/set_attrs', [PostController::class, 'update'])->name('post.update');

Route::delete('post/{post_id}/destroy', [PostController::class, 'destroy'])->name('post.destroy');

Route::get('/profile/feed', [FrontController::class, 'profile_feed'])->name('profile.feed');

Route::get('/profile/advanced', [FrontController::class, 'profile_advanced'])->name('profile.advanced');

Route::post('/profile/destroy', [UserController::class, 'destroy'])->name('profile.destroy');
