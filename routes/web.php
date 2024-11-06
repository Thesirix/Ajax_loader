<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;





Route::get('students', [StudentController::class,'index']);
Route::get('fetch-students', [StudentController::class,'fetchstudent']);
Route::post('students', [StudentController::class,'store']);
Route::post('/update-student/{id}', [StudentController::class, 'updateStudentInfo']);


Route::get('/', function () {
    return view('welcome');
});
