<?php

namespace App\Repository;

use App\Models\Exam;
use Exception;

class ExamRepositoryImpl implements IExamRepository
{
    public function getExamById($examId)
    {
        $exam = Exam::find($examId);
        return $exam;
    }

    public function getAllExams()
    {
        $exams = Exam::all();
        return $exams;
    }

    public function createExam($examDetails) : Exam|null
    {
        try {

            $exam = new Exam();

            $exam->name = $examDetails['name'];

            $exam->file_url = $examDetails['file'];

            $exam->save();

            return $exam;

        } catch (Exception $e) {

            return null;
        }
    }

    public function updateExam($examId, $examDetails)
    {

    }

    public function deleteExam($examId)
    {
        try {

            $exam = Exam::findOrFail($examId);

            $exam->delete();

            return true;

        } catch (Exception $e) {
            // TODO: Write error in logger
            return false;
        }
    }
}