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

    public function store (Request $request) : JsonResponse
    {
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
}
