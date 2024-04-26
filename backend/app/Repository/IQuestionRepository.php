<?php

namespace App\Repository;

use App\Models\Question;
use Exception;
use Illuminate\Database\Eloquent\Collection;

interface IQuestionRepository
{

    public function createQuestion(array $questionDetails) : Question|null|string;

    public function getAllQuestionsByExamId(int $examId) : Collection|Question|null;

    public function getAllQuestionsByExamIdAndTopicId(int $examId, int $topicId) : Collection|Question|null;

}