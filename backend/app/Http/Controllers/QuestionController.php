<?php

namespace App\Http\Controllers;

use App\Services\IQuestionService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    private IQuestionService $questionService;

    public function __construct(IQuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function indexByExam(int $examId)
    {
        return $this->questionService->getAllQuestionsByExamId($examId);
    }
}
