<?php

namespace App\Services;

use DOMXPath;

interface IExamProcessor
{
    public function processHTML(string $pathToHtml): bool;

    public function getExamHtmlPaths(string $pathToHtml): array;

    public function loadHtml($htmlPath): DOMXPath;
}