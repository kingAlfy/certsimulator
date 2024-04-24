<?php

namespace App\Repository;
use Illuminate\Database\Eloquent\Collection;

interface IExamRepository
{
    public function getExamById($examId);

    public function getAllExams() : Collection|null;

    public function createExam($examDetails);

    public function updateExam($examId, $examDetails);

    public function deleteExam($examId);

}