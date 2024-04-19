<?php

namespace App\Services;

use App\Models\Exam;
use App\Repository\IExamRepository;
use Illuminate\Support\Facades\Storage;

class ExamServiceImpl implements IExamService
{

    private IExamRepository $examRepository;

    private IExamUnzipper $examUnzipper;

    public function __construct(IExamRepository $examRepository, IExamUnzipper $examUnzipper)
    {
        $this->examRepository = $examRepository;
        $this->examUnzipper = $examUnzipper;
    }

    public function createExam($examRequest) : Exam|null
    {
        try {
            // Move file to storage
            $file_url = $examRequest['file']->store('public/exams');
            // Change file to file_url
            $examRequest['file'] = Storage::url($file_url);

            // Unzip files
            $this->examUnzipper->unzipExam($file_url);

            // Procesar los html

            // Remove unzipped folder
            /* $pathToExamUnzipped = $this->examUnzipper->getPathToExamUnzipped();
            Storage::deleteDirectory($pathToExamUnzipped); */

            // Create exam in database
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