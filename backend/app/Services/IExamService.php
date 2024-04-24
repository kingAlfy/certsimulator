<?php

namespace App\Services;
use App\Models\Exam;
use Illuminate\Database\Eloquent\Collection;

interface IExamService
{

    public function createExam(mixed $examRequest) : Exam|null;

    public function deleteExam(int $examId) : array;

    public function getExam(int $examId) : Exam|null;

    public function getAllExams() : Collection|null;

}
