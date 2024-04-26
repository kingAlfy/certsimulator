<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

interface IQuestionService
{

    public function getAllQuestionsByExam(int $examId) : Collection|Question;

    public function getAllQuestionsByExamAndTopic(int $examId, int $topicID) : Collection|Question|null;

    public function getAllQuestionsByExamAndTopicAndQuestion(int $examId, int $topicId, int $questionNumber) : Question|null;

}