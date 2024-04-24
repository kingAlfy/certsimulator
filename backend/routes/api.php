<?php

use App\Http\Controllers\ExamController;
use App\Http\Controllers\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// TODO: Securizar con middleware todos los endpoint

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/exams', [ExamController::class, 'index']);

Route::get('/exams/{examId}', [ExamController::class, 'show']);

Route::post('/exams', [ExamController::class, 'store']);

Route::delete('/exams/{examId}', [ExamController::class, 'destroy']);


Route::get('/exams/{examId}/questions', [QuestionController::class, 'indexByExam']);

Route::get('/exams/{examId}/{topicId}/questions', [QuestionController::class, 'indexByExamAndTopic']);

Route::get('/exams/{examId}/{topicId}/{questionNumber}', [QuestionController::class, 'indexByExamAndTopic']);