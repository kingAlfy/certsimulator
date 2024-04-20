<?php

namespace App\Services;

use DOMNodeList;
use DOMXPath;

interface IExamProcessor
{
    public function processHTML(string $pathToHtml): bool|null;

    public function getExamHtmlPaths(string $pathToHtml): array;

    public function loadHtml($htmlPath): DOMXPath|bool;

    public function loadQuestionCards(DOMXPath $xpath): DOMNodeList;
}