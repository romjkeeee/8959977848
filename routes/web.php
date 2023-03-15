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

Route::get('/', [App\Http\Controllers\QuestionController::class, 'index']);
Route::resource('question', App\Http\Controllers\QuestionController::class)->except(['show','edit']);
Route::get('profile', [App\Http\Controllers\ProfileController::class,'edit'])->name('profile');
Route::get('profile/{user}/show', [App\Http\Controllers\ProfileController::class,'show'])->name('profile.show');
Route::put('profile/{user}', [App\Http\Controllers\ProfileController::class,'update'])->name('profile.update');
Route::group(['namespace' => 'question', 'prefix' => 'question'], function () {
    Route::get('/{question:slug}', [App\Http\Controllers\QuestionController::class, 'show'])->name('question.show');
    Route::get('/{question:slug}/edit', [App\Http\Controllers\QuestionController::class, 'edit'])->name('question.edit');
});
Route::resource('question.answers', App\Http\Controllers\AnswerController::class)->only(['store', 'edit', 'update']);
Route::delete('answers/{answer}', [App\Http\Controllers\AnswerController::class, 'destroy'])->name('answers.destroy');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/questions/{question}/vote', [App\Http\Controllers\QuestionController::class, 'vote']);
Route::post('/answers/{answer}/vote', [App\Http\Controllers\AnswerController::class, 'vote']);
