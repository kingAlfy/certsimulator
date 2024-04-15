<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function store (Request $request){
        $exam = Exam::create($request->all());
    }
}
