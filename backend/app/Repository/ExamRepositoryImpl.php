<?php

namespace App\Repository;

use App\Models\Exam;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ExamRepositoryImpl implements IExamRepository
{

    public function getExamById(int $examId) : Exam|null
    {

        try {

            $exam = Exam::find($examId);

            return $exam;

        } catch (Exception $e) {

            return null;

        }

    }

    public function getAllExams() : Collection|null
    {

        try {

            $exams = Exam::all();

            return $exams;

        } catch (Exception $e) {

            return null;

        }

    }

    public function createExam(array $examDetails) : Exam|null
    {

        try {

            $exam = new Exam();

            $exam->name = $examDetails['name'];

            $exam->file_url = $examDetails['file'];

            $exam->path_to_assets = $examDetails['path_to_assets'];

            $exam->save();

            return $exam;

        } catch (Exception $e) {

            return null;

        }

    }

    public function deleteExam(int $examId) : bool
    {

        try {

            $exam = Exam::findOrFail($examId);

            $isSuccesfull = $exam->delete();

            return $isSuccesfull;

        } catch (Exception $e) {
            // TODO: Write error in logger
            return false;

        }

    }
}