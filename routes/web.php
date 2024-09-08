<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[UserController::class,'home'])->name('home');
Route::post('/create_todo',[UserController::class,'create_todo'])->name('create_todo');
Route::post('/Update_todo/{id}',[UserController::class,'Update_todo'])->name('Update_todo');
Route::get('/update_todo_list/{id}',[UserController::class,'update_todo_list'])->name('update_todo_list');
Route::get('/delete_todo_list/{id}',[UserController::class,'delete_todo_list'])->name('delete_todo_list');
Route::post('/todo_list_updated_confirmed/{id}',[UserController::class,'todo_list_updated_confirmed'])->name('todo_list_updated_confirmed');
