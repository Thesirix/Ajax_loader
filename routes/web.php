<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;





Route::get('/', [StudentController::class,'index']);
Route::get('fetch-students', [StudentController::class,'fetchstudent']);
Route::post('students', [StudentController::class,'store']);



