<?php

namespace App\Services;

interface IExamService
{
    public function createExam(mixed $examRequest);

    public function updateExam(array $data);

    public function deleteExam(int $data);

    public function getExam(int $id);
}
