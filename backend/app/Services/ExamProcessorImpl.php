<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;

class ExamProcessorImpl implements IExamProcessor
{
    public function processHTML(string $pathToHtml): bool
    {
        $examsHtmlPaths = $this->getExamHtmlPaths($pathToHtml);
        foreach ($examsHtmlPaths as $htmlPath) {

            $xpath = $this->loadHtml($htmlPath);

            /* // Find all divs that contains the classname 'exam-question-card'
            $question_divs = $xpath->query("//div[contains(@class, 'exam-question-card')]"); */


        }

        return true;

        /* // Leer el contenido del archivo HTML
        $html = file_get_contents("AZ-900 Exam - Free Actual Q&As, Page 2 ExamTopics.htm");

        // Crear un objeto DOMDocument
        $dom = new DOMDocument();

        // Suprimir errores de HTML mal formado
        libxml_use_internal_errors(true);

        // Cargar el HTML en el objeto DOMDocument
        $dom->loadHTML($html);

        // Suprimir errores de HTML mal formado
        libxml_clear_errors();

        // Crear un objeto DOMXPath
        $xpath = new DOMXPath($dom);

        // Encontrar todos los divs con la clase "exam-question-card"
        $question_divs = $xpath->query("//div[contains(@class, 'exam-question-card')]");

        // Inicializar array para almacenar las preguntas en formato JSON
        $questions_json = [];
        $cnt = 1;

        // Iterar sobre cada div de pregunta
        foreach ($question_divs as $div) {
            $question_json = [];

            // Extraer número de pregunta y tema
            $header = $xpath->query(".//div[contains(@class, 'card-header')]", $div)->item(0);
            $question_json['question'] = trim(explode(' ', explode('#', $header->textContent)[1])[0]);
            $question_json['topic'] = trim($xpath->query(".//span[contains(@class, 'question-title-topic')]", $header)->item(0)->textContent);

            // Extraer enunciado de la pregunta
            $body = $xpath->query(".//div[contains(@class, 'card-body')]", $div)->item(0);
            $question = [];
            $question_text = trim($xpath->query(".//p[contains(@class, 'card-text')]", $body)->item(0)->textContent);
            $question_img = $xpath->query(".//p[contains(@class, 'card-text')]//img", $body)->item(0);
            if ($question_img) {
                $question['img'] = $question_img->getAttribute('src');
            }
            $question['text'] = $question_text;

            $question_json['question_text'] = $question;

            // Extraer opciones de la pregunta
            $choices_container = $xpath->query(".//div[contains(@class, 'question-choices-container')]", $body)->item(0);
            if ($choices_container) {
                $choices_li = $xpath->query(".//li[contains(@class, 'multi-choice-item')]", $choices_container);
                $question_choices = [];
                foreach ($choices_li as $choice_li) {
                    $choice_letter = $xpath->query(".//span[contains(@class, 'multi-choice-letter')]", $choice_li)->item(0)->getAttribute('data-choice-letter');
                    $choice_text = trim(preg_replace('/\s+/', ' ', $choice_li->textContent));
                    $choice_text = trim(explode('.', $choice_text)[1]);
                    $question_choices[$choice_letter] = $choice_text;
                }
                $question_json['question_choices'] = $question_choices;
            }

            // Extraer solución
            $solution = $xpath->query(".//span[@class='correct-answer']", $div)->item(0);
            $solution_img = $xpath->query(".//span[@class='correct-answer']//img", $div)->item(0);
            if ($solution_img) {
                $question_json['solution'] = $solution_img->getAttribute('src');
            } else {
                $question_json['solution'] = trim($solution->textContent);
            }

            // Extraer descripción de la respuesta
            $answer_description = trim($xpath->query(".//span[contains(@class, 'answer-description')]", $div)->item(0)->textContent);
            $question_json['answer_description'] = $answer_description;

            // Extraer comentarios
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
            $question_json['comments'] = $comments;

            // Agregar pregunta a la lista
            $questions_json[] = $question_json;
        } */
    }

    public function getExamHtmlPaths(string $pathToHtml) : array
    {
        $htmlFiles = glob($pathToHtml . '/*.htm');
        return $htmlFiles;
    }

    public function loadHtml($htmlPath): DOMXPath
    {
        // Read HTML content
        $html = file_get_contents($htmlPath);

        $dom = new DOMDocument();

        $dom->loadHTML($html);

        // Delete html format errors
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

        return $xpath;
    }
}