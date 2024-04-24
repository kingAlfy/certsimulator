<?php

namespace App\Services;

use DOMNodeList;
use DOMXPath;

interface IExamProcessor
{
    public function processHTML(string $pathToHtml, int $examId): bool|null;

    public function getExamHtmlPaths(string $pathToHtml): array;

    public function loadHtml($htmlPath): DOMXPath|bool;
}