<?php

namespace App\Services;

interface IExamService
{
    public function createExam(array $data);

    public function updateExam(array $data);

    public function deleteExam(int $data);

    public function getExam(int $id);
}
