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


    /**
     * Create exam, if it does fail return null
     *
     * @param mixed $examRequest
     * @return Exam|null|boolean
     */
    public function createExam(mixed $examRequest) : Exam|null|bool
    {
        try {

            // Move file to storage
            $file_url = $examRequest['file']->store('public/exams');

            // Change file to file_url
            $examRequest['file'] = Storage::url($file_url);

            // Unzip files
            $pathToUnzippedExam = $this->examUnzipper->unzipExam($file_url);

            if (!$pathToUnzippedExam) {
                return null;
            }

            // Create exam in database
            $exam = $this->examRepository->createExam($examRequest);

            // Change file names inside of exam unzipped folder - not working

            // Procesar los html
            $result = $this->processor->processHTML($pathToUnzippedExam, $exam->id);

            if (!$result) {

                return null;

            }

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