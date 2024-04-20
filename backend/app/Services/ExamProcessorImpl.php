<?php

namespace App\Services;

use DOMDocument;
use DOMNode;
use DOMNodeList;
use DOMXPath;
use Exception;

class ExamProcessorImpl implements IExamProcessor
{
    public function processHTML(string $pathToHtml): bool|null
    {
        $examsHtmlPaths = $this->getExamHtmlPaths($pathToHtml);

        foreach ($examsHtmlPaths as $htmlPath) {

            $xpath = $this->loadHtml($htmlPath);

            if (!$xpath){
                return null;
            }

            $question_divs = $this->loadQuestionCards($xpath);

            foreach ($question_divs as $div) {
                $questionNumberAndTopic = $this->loadQuestionNumberAndTopic($xpath, $div);

                $question = $this->loadQuestion($xpath, $div);

                $questionChoices = $this->loadQuestionChoices($xpath, $div);

                $solution = $this->loadSolutionForQuestion($xpath, $div);

                $solutionDescription = $this->loadSolutionDescription($xpath, $div);

                $questionComments = $this->loadQuestionComments($xpath, $div);
                dd($questionComments);

            }


        }
    }

    public function getExamHtmlPaths(string $pathToHtml) : array
    {
        $htmlFiles = glob($pathToHtml . '/*.htm');
        return $htmlFiles;
    }

    public function loadHtml($htmlPath): DOMXPath|bool
    {
        try {
            // Read HTML content
            $html = file_get_contents($htmlPath);

            $dom = new DOMDocument();

            // Suprimir errores de HTML mal formado
            libxml_use_internal_errors(true);

            $dom->loadHTML($html);

            // Suprimir errores de HTML mal formado
            libxml_clear_errors();

            $xpath = new DOMXPath($dom);

            return $xpath;
        } catch (Exception $e) {
            return false;
        }

    }

    public function loadQuestionCards(DOMXPath $xpath): DOMNodeList
    {
        // Find all divs that contains the classname 'exam-question-card'
        $question_divs = $xpath->query("//div[contains(@class, 'exam-question-card')]");

        return $question_divs;
    }

    public function loadQuestionNumberAndTopic(DOMXPath $xpath, DOMNode $div)
    {
        $question_headers = [];
        $header = $xpath->query(".//div[contains(@class, 'card-header')]", $div)->item(0);
        $question_headers['question'] = trim(explode(' ', explode('#', $header->textContent)[1])[0]);
        $question_headers['topic'] = explode(' ', trim($xpath->query(".//span[contains(@class, 'question-title-topic')]", $header)->item(0)->textContent))[1];
        return $question_headers;
    }

    public function loadQuestion(DOMXPath $xpath, DOMNode $div)
    {
        $body = $xpath->query(".//div[contains(@class, 'card-body')]", $div)->item(0);
        $question = [];
        $question_text = trim($xpath->query(".//p[contains(@class, 'card-text')]", $body)->item(0)->textContent);
        $question_img = $xpath->query(".//p[contains(@class, 'card-text')]//img", $body)->item(0);
        if ($question_img) {
            $question['img'] = $question_img->getAttribute('src');
        }
        $question['text'] = $question_text;
        return $question;
    }

    public function loadQuestionChoices(DOMXPath $xpath, DOMNode $div)
    {
        $choices_container = $xpath->query(".//div[contains(@class, 'question-choices-container')]", $div)->item(0);
        if ($choices_container) {
            $choices_li = $xpath->query(".//li[contains(@class, 'multi-choice-item')]", $choices_container);
            $question_choices = [];
            foreach ($choices_li as $choice_li) {
                $choice_letter = $xpath->query(".//span[contains(@class, 'multi-choice-letter')]", $choice_li)->item(0)->getAttribute('data-choice-letter');
                $choice_text = trim(preg_replace('/\s+/', ' ', $choice_li->textContent));
                $choice_text = trim(explode('.', $choice_text)[1]);
                $question_choices[$choice_letter] = $choice_text;
            }
            return $question_choices;
        }
    }

    public function loadSolutionForQuestion(DOMXPath $xpath, DOMNode $div) : string
    {
        $solution = $xpath->query(".//span[@class='correct-answer']", $div)->item(0);
        $solution_img = $xpath->query(".//span[@class='correct-answer']//img", $div)->item(0);
        if ($solution_img) {
            return $solution_img->getAttribute('src');
        } else {
            return trim($solution->textContent);
        }
    }

    public function loadSolutionDescription(DOMXPath $xpath, DOMNode $div) : string
    {
        $answer_description = trim($xpath->query(".//span[contains(@class, 'answer-description')]", $div)->item(0)->textContent);
        return  $answer_description;
    }

    public function loadQuestionComments(DOMXPath $xpath, DOMNode $div) : array
    {
        $comments = [];
        $comments_div = $xpath->query(".//div[contains(@class, 'media-body')]", $div);
        foreach ($comments_div as $comment_div) {
            $badge = $xpath->query(".//span[contains(@class, 'badge')]", $comment_div)->item(0);
            if ($badge) {
                $comment = [];
                $comment['username'] = trim($xpath->query(".//h5[contains(@class, 'comment-username')]", $comment_div)->item(0)->textContent);
                $comment['content'] = trim($xpath->query(".//div[contains(@class, 'comment-content')]", $comment_div)->item(0)->textContent);
                $comment['badge'] = trim($badge->textContent);
                $comment['date'] = trim($xpath->query(".//span[contains(@class, 'comment-date')]", $comment_div)->item(0)->textContent);
                $comments[] = $comment;
            }
        }
        return $comments;
    }
}