<?php

namespace App\Http\Controllers;

use App\Services\IQuestionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends Controller
{
    private IQuestionService $questionService;

    public function __construct(IQuestionService $questionService)
    {

        $this->questionService = $questionService;

    }

    public function indexByExam(int $examId) : JsonResponse
    {

        $questions = $this->questionService->getAllQuestionsByExam($examId);

        if (!isset($questions)){

            return response()->json([
                'message' => 'Some error has occurred'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        return response()->json($questions, Response::HTTP_OK);

    }

    public function indexByExamAndTopic(int $examId, int $topicId) : JsonResponse
    {

        $questions = $this->questionService->getAllQuestionsByExamAndTopic($examId, $topicId);

        if (!isset($questions)){

            return response()->json([
                'message' => 'Some error has occured'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        if (count($questions) == 0){

            return response()->json([
                'message' => 'Questions not found'
            ], Response::HTTP_BAD_REQUEST);

        }

        return response()->json($questions, Response::HTTP_OK);

    }

}
