<?php

namespace App\Services;

interface IExamUnzipper
{
    public function unzipExam(string $relativeRouteToExam): bool|string;
}