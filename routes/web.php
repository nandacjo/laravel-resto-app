<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route 403
Route::get('403', function () {
  abort(403);
})->name('403');

Route::middleware('auth')->controller(DashboardController::class)->group(function () {
  Route::get('/dashboard', 'index')->name('dashboard');
});
// Route Category
Route::middleware('auth')->controller(CategoryController::class)->group(function () {
  Route::get('category', 'index')->name('category');
  Route::post('category', 'store')->name('category.store');
  Route::get('fetch-cateogory', 'fetchCategory')->name('fetch.category');
  Route::get('category/edit', 'edit')->name('category.edit');
  Route::post('category/edit', 'update')->name('category.update');
  Route::get('category/trash', 'trashCategory')->name('category.trash.category');
  Route::get('category/fetch-trash-category', 'fetchTrashCategory')->name('category.fetch.trash.category');
  Route::post('category/destroy', 'destroy')->name('category.destroy');
  Route::post('category/restore', 'restore')->name('category.restore');
  Route::post('category/destroy/selected', 'destroySelected')->name('category.destroy.selected');
});

// Route User
Route::middleware('auth')->controller(UserController::class)->group(function () {
  Route::get('user', 'index')->name('user');
  Route::post('user', 'store')->name('user.store');
  Route::get('fetchUser', 'fetchUser')->name('fetch.user');
  Route::get('user/edit', 'edit')->name('user.edit');
  Route::post('user/edit', 'update')->name('user.update');
  Route::post('user/destroy', 'destroy')->name('user.destroy');
  Route::post('user/destroy/selected', 'destroySelected')->name('user.destroy.selected');
});

// Route Login
Route::controller(LoginController::class)->group(function () {
  Route::get('/login', 'index')->name('login.index');
  Route::post('/login', 'store')->name('login.store');
  Route::post('/logout', 'logout')->name('logout');
});