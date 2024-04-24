<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

interface IQuestionService
{

    public function getAllQuestionsByExamId(int $examId) : Collection|Question;

}