<?php

namespace App\Services;

use App\Models\Exam;
use App\Repository\IExamRepository;
use Illuminate\Support\Facades\Storage;

class ExamServiceImpl implements IExamService
{

    private IExamRepository $examRepository;

    private IExamUnzipper $examUnzipper;

    private IExamProcessor $processor;

    public function __construct(IExamRepository $examRepository, IExamUnzipper $examUnzipper, IExamProcessor $processor)
    {
        $this->examRepository = $examRepository;
        $this->examUnzipper = $examUnzipper;
        $this->processor = $processor;
    }

    public function createExam($examRequest) : Exam|null|bool
    {
        try {

            // Move file to storage
            $file_url = $examRequest['file']->store('public/exams');

            // Change file to file_url
            $examRequest['file'] = Storage::url($file_url);

            // Unzip files
            $isSuccesfull = $this->examUnzipper->unzipExam($file_url);

            if (!$isSuccesfull) {
                return null;
            }

            // Procesar los html
            $result = $this->processor->processHTML($this->examUnzipper->getPathToExamUnzipped());

            if (!$result) {
                return null;
            }

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