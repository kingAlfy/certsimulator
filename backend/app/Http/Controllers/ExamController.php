<?php

namespace App\Http\Controllers;

use App\Services\IExamService;
use App\Services\IExamUnzipper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExamController extends Controller
{
    private IExamService $examService;

    public function __construct(IExamService $examService)
    {
        $this->examService = $examService;
    }

    public function store(Request $request) : JsonResponse
    {
        // TODO: Name must be unique
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'file' => ['required', 'mimes:7z']
        ]);

        $examResponse = $this->examService->createExam($request->all());

        if (!isset($examResponse)){

            return response()->json([
                'message'=> 'Some error has occurred'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json($examResponse, Response::HTTP_CREATED);
    }

    public function index() : JsonResponse
    {

        $exams = $this->examService->getAllExams();

        if (!isset($exams)){
            return response()->json([
                'message'=> 'Some error has occurred'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($exams, Response::HTTP_OK);

    }

    public function show(int $examId) : JsonResponse
    {

        $exam = $this->examService->getExam($examId);

        if (!isset($exam)){
            return response()->json([
                'message'=> 'Exam not found'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json($exam, Response::HTTP_OK);

    }

}
