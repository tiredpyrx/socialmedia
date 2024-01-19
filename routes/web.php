<?php

use App\Http\Controllers\FrontController;
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

Route::get('register', [UserController::class, 'show_create'])->name('create.show');
Route::post('register', [UserController::class, 'create'])->name('create');

Route::get('login', [UserController::class, 'show_login'])->name('login.show');
Route::post('login', [UserController::class, 'login'])->name('login');

Route::post('logout', [UserController::class, 'logout'])->name('logout');

Route::get('/users', [FrontController::class, 'show_users'])->name('users.show');

Route::get('/feed', [FrontController::class, 'show_feed'])->name('feed.show');

Route::get('/post', [FrontController::class, 'show_post'])->name('post.show');
Route::post('/post', [UserController::class, 'create_post'])->name('post.create');

Route::get('/profile', [UserController::class, 'show_profile'])->name('profile.show');
Route::get('/profile-edit', [UserController::class, 'show_edit'])->name('profile.edit.show');
Route::put('/profile-edit', [UserController::class, 'edit'])->name('profile.edit');
