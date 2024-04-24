<?php

namespace App\Services;

use App\Models\Question;
use App\Repository\IQuestionRepository;
use Illuminate\Database\Eloquent\Collection;

class QuestionServiceImpl implements IQuestionService
{
    private IQuestionRepository $questionRepository;
    public function __construct(IQuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function getAllQuestionsByExamId(int $examId): Collection|Question
    {
        return $this->questionRepository->getAllQuestionsByExam($examId);
    }
}