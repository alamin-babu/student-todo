<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;

// API Routes for CRUD
Route::get('/students', [StudentController::class, 'index']);
Route::post('/students', [StudentController::class, 'store']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::delete('/students/{id}', [StudentController::class, 'destroy']);

// To load the HTML page
Route::view('/', 'todo');