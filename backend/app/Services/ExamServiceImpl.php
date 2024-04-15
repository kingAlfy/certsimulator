<?php

namespace App\Services;

use App\Models\Exam;
use App\Repository\IExamRepository;
use Illuminate\Support\Facades\Storage;

class ExamServiceImpl implements IExamService
{

    private IExamRepository $examRepository;

    public function __construct(IExamRepository $examRepository)
    {
        $this->examRepository = $examRepository;
    }

    public function createExam($examRequest) : Exam|null
    {
        try {
            // Move file to storage
            $file_url = $examRequest['file']->store('public/exams');

            // Change file to file_url
            $examRequest['file'] = Storage::url($file_url);
            $exam = $this->examRepository->createExam($examRequest);
            return $exam;
        } catch (\Throwable $th) {
            return null;
        }
    }

    public function updateExam($data)
    {

    }

    public function deleteExam(int $data)
    {

    }

    public function getExam(int $id)
    {

    }
}