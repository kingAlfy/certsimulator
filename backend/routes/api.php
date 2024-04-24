<?php

use App\Http\Controllers\ExamController;
use App\Http\Controllers\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/exams', [QuestionController::class, 'index']);
Route::get('/exams/{examId}', [QuestionController::class, 'indexById']);
Route::post('/exams', [ExamController::class, 'store']);


Route::get('/exams/{examId}/questions', [QuestionController::class, 'indexByExam']);


