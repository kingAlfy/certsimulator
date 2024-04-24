<?php

namespace App\Repository;

use App\Models\Exam;
use Illuminate\Database\Eloquent\Collection;

interface IExamRepository
{
    public function getExamById($examId) : Exam|null;

    public function getAllExams() : Collection|null;

    public function createExam($examDetails);

    public function deleteExam($examId);

}