<?php

namespace App\Repository;

interface IExamRepository
{
    public function getExamById($examId);

    public function getAllExams();

    public function createExam($examDetails);

    public function updateExam($examId, $examDetails);

    public function deleteExam($examId);

}