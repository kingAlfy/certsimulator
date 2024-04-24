<?php

namespace App\Repository;

use App\Models\Exam;
use Illuminate\Database\Eloquent\Collection;

interface IExamRepository
{
    public function getExamById(int $examId) : Exam|null;

    public function getAllExams() : Collection|null;

    public function createExam(array $examDetails) : Exam|null;

    public function deleteExam(int $examId) : bool;

}