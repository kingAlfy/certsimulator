<?php

namespace App\Repository;

use App\Models\Question;
use Exception;
use Illuminate\Database\Eloquent\Collection;

interface IQuestionRepository
{
    public function createQuestion(array $questionDetails) : Question|null|string;
    public function getAllQuestionsByExam(int $examId) : Collection|Question|null;
}