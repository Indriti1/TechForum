<?php

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

use App\Http\Controllers\TopicsController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect('/categories');
});

Auth::routes();

// Category Routes 

Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoriesController::class, 'show'])->name('categories.show');

// Profile Routes 

Route::get('/profiles/{profile}', [ProfilesController::class, 'show'])->name('profiles.show');
Route::get('/profile/edit', [ProfilesController::class, 'edit'])->name('profiles.edit')->middleware('auth');
Route::post('/profiles/update', [ProfilesController::class, 'update'])->name('profiles.update')->middleware('auth');

// Topic Routes 

Route::get('/topics/create', [TopicsController::class, 'create'])->name('topics.create')->middleware('auth');
Route::post('/topics', [TopicsController::class, 'store'])->name('topics.store');
Route::get('/topics/{topic}', [TopicsController::class, 'show'])->name('topics.show');
Route::get('/topics/{id}/delete', [TopicsController::class, 'userDeleteTopic'])->name('userDeleteTopic');

// Reply Routes

Route::post('/replies', [RepliesController::class, 'store'])->name('replies.store');
Route::get('/replies/{id}/delete', [RepliesController::class, 'userDeleteReply'])->name('userDeleteReply');

// Helping Routes (Image Upload, Ajax Likes, Search)

Route::post('images/upload', [ImageController::class, 'upload'])->name('ckeditor.upload');
Route::get('/likes/create', [AjaxController::class, 'create'])->name('likes.create');
Route::post('/likes/store', [AjaxController::class, 'store'])->name('likes.create');
Route::get('/search', [SearchController::class, 'index'])->name('search.index');

// Admin Dashboard

Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// Admin Users Routes

Route::get('/admin/users', [UserController::class, 'index'])->name('indexUsers')->middleware('auth');
Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('editUser')->middleware('auth');
Route::post('/admin/users/{id}/update', [UserController::class, 'update'])->name('updateUser')->middleware('auth');
Route::get('/admin/users/{id}/delete', [UserController::class, 'delete'])->name('deleteUser')->middleware('auth');

// Admin Replies Routes

Route::get('/admin/replies', [RepliesController::class, 'index'])->name('indexReplies')->middleware('auth');
Route::get('/admin/replies/{id}/delete', [RepliesController::class, 'delete'])->name('deleteReply');

// Admin Topics Routes

Route::get('/admin/topics', [TopicsController::class, 'index'])->name('indexTopics')->middleware('auth');
Route::get('/admin/topics/{id}/delete', [TopicsController::class, 'delete'])->name('deleteTopic')->middleware('auth');

// Admin Categories Routes

Route::get('/admin/categories', [CategoriesController::class, 'showCategories'])->name('indexCategories')->middleware('auth');
Route::get('/admin/categories/create', [CategoriesController::class, 'create'])->name('create')->middleware('auth');
Route::post('/admin/categories/store', [CategoriesController::class, 'store'])->name('store')->middleware('auth');
Route::get('/admin/categories/{id}/edit', [CategoriesController::class, 'edit'])->name('editCategory')->middleware('auth');
Route::post('/admin/categories/{id}/update', [CategoriesController::class, 'update'])->name('updateCategory')->middleware('auth');
Route::get('/admin/categories/{id}/delete', [CategoriesController::class, 'delete'])->name('deleteCategory')->middleware('auth');



