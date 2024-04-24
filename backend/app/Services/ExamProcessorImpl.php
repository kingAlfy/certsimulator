<?php

namespace App\Services;

use App\Repository\ICommentRepository;
use App\Repository\IQuestionRepository;
use DOMDocument;
use DOMNode;
use DOMNodeList;
use DOMXPath;
use Exception;
use Illuminate\Support\Facades\Storage;

class ExamProcessorImpl implements IExamProcessor
{
    private IQuestionRepository $questionRepository;

    private ICommentRepository $commentRepository;

    public function __construct(IQuestionRepository $questionRepository, ICommentRepository $commentRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->commentRepository = $commentRepository;
    }

    public function processHTML(string $pathToHtml, int $examId): bool|null
    {
        $examsHtmlPaths = $this->getExamHtmlPaths($pathToHtml);

        foreach ($examsHtmlPaths as $htmlPath) {

            $xpath = $this->loadHtml($htmlPath);

            if (!$xpath){
                return null;
            }

            $assetFolderUrl = $this->getAssetsFolderUrl($htmlPath);

            $question_divs = $this->loadQuestionCards($xpath);

            foreach ($question_divs as $div) {

                $questionDetails = [];

                $questionDetails["exam_id"] = $examId;

                // Load headers, topic and number of the question

                $questionNumberAndTopic = $this->loadQuestionNumberAndTopic($xpath, $div);

                if (!isset($questionNumberAndTopic["question_number"]) || !isset($questionNumberAndTopic['topic_id'])){
                    return null;
                }

                $questionDetails['question_number'] = $questionNumberAndTopic['question_number'];

                $questionDetails['topic_id'] = $questionNumberAndTopic['topic_id'];

                // Load question

                $question = $this->loadQuestion($xpath, $div, $assetFolderUrl);

                if (!isset($question)){
                    return null;
                }

                $questionDetails['question_text'] = $question;

                // Load choices

                $questionChoices = $this->loadQuestionChoices($xpath, $div);

                if (isset($questionChoices)){
                    $questionDetails['choices'] = implode(';', $questionChoices);
                }

                $solution = $this->loadSolutionForQuestion($xpath, $div, $assetFolderUrl);

                if (!isset($solution)){
                    return null;
                }

                $questionDetails['solution'] = $solution;

                $solutionDescription = $this->loadSolutionDescription($xpath, $div, $assetFolderUrl);

                $questionDetails['solution_description'] = $solutionDescription;

                $newQuestion = $this->questionRepository->createQuestion($questionDetails);

                $questionComments = $this->loadQuestionComments($xpath, $div);

                if (count($questionComments) > 0){

                    foreach ($questionComments as $commentDetails) {

                        $commentDetails['question_id'] = $newQuestion->id;

                        $this->commentRepository->createCommentForQuestion($commentDetails);

                    }

                }

            }
        }

        return true;
    }

    public function getExamHtmlPaths(string $pathToHtml) : array
    {
        $htmlFiles = glob($pathToHtml . '/*.htm');
        return $htmlFiles;
    }


    /**
     * Return a url to asset folder
     *
     * @param string $htmlPath
     * @return string Url to asset folder
     */
    public function getAssetsFolderUrl(string $htmlPath) : string
    {
        // Obtener el nombre del archivo sin la extensión
        $originalFile = pathinfo($htmlPath, PATHINFO_FILENAME);

        // Crear la nueva ruta con la extensión "_files"
        $assetFolderPath = dirname($htmlPath) . '/' . $originalFile . '_files';

        $assetFolderPath = str_replace('\\', '/', $assetFolderPath);

        $arrayAssetFolderPath = explode('/', $assetFolderPath);

        $toStorage = array_slice($arrayAssetFolderPath, -4);

        $toStorageUrl = implode('/', $toStorage);

        $url = env('APP_URL') . Storage::url($toStorageUrl);

        return $url;
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

    private function loadQuestionCards(DOMXPath $xpath): DOMNodeList
    {
        // Find all divs that contains the classname 'exam-question-card'
        $question_divs = $xpath->query("//div[contains(@class, 'exam-question-card')]");

        return $question_divs;
    }

    private function loadQuestionNumberAndTopic(DOMXPath $xpath, DOMNode $div) : array|null
    {
        $question_headers = [];

        $header = $xpath->query(".//div[contains(@class, 'card-header')]", $div)->item(0);

        $question_headers['question_number'] = trim(explode(' ', explode('#', $header->textContent)[1])[0]);

        $question_headers['topic_id'] = explode(' ', trim($xpath->query(".//span[contains(@class, 'question-title-topic')]", $header)->item(0)->textContent))[1];

        return $question_headers;
    }


    /**
     * Load a question and return the question with <img src'url/to/resource' />
     *
     * @param DOMXPath $xpath
     * @param DOMNode $div
     * @param string $assetFolderUrl
     * @return string base64(question_text)
     */
    private function loadQuestion(DOMXPath $xpath, DOMNode $div, string $assetFolderUrl) : string
    {

        $body = $xpath->query(".//div[contains(@class, 'card-body')]", $div)->item(0);

        $node = $xpath->query(".//p[contains(@class, 'card-text')]", $body)->item(0);

        $images = $xpath->query(".//img", $node);

        foreach ($images as $image) {
            // Obtener el valor actual del atributo src
            $src = $image->getAttribute("src");

            // Utilizar expresiones regulares para extraer el nombre de archivo de la URL original
            $fileName = basename($src);

            // Concatenar el nuevo directorio con el mismo nombre de archivo
            $newSrc =  $assetFolderUrl . '/' . $fileName;
            // Reemplazar el atributo src por el nuevo valor deseado
            $image->setAttribute("src", $newSrc);
        }

        $question_text = $node->ownerDocument->saveHTML($node);

        $question_text = str_replace("amp;","", $question_text);

        $question_text = str_replace("\n","", $question_text);

        $question_text = preg_replace('/ {3,}/', ' ', $question_text);

        $question_text = str_replace('"', "'", $question_text);

        $question_text = base64_encode($question_text);
        return $question_text;
    }

    private function loadQuestionChoices(DOMXPath $xpath, DOMNode $div) : array|null
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

        return null;
    }

    private function loadSolutionForQuestion(DOMXPath $xpath, DOMNode $div, $assetFolderUrl) : string
    {
        $solution = $xpath->query(".//span[@class='correct-answer']", $div)->item(0);

        $solution_img = $xpath->query(".//span[@class='correct-answer']//img", $div)->item(0);

        if ($solution_img) {

            $filename = explode('/', $solution_img->getAttribute('src'));

            $filename = end($filename);

            return $assetFolderUrl . '/' .$filename;

        } else {

            return trim($solution->textContent);

        }
    }

    /**
     * Load a solution description and return the description with <img src'url/to/resource' />
     *
     * @param DOMXPath $xpath
     * @param DOMNode $div
     * @param string $assetFolderUrl
     * @return string base64(solution_description)
     */
    private function loadSolutionDescription(DOMXPath $xpath, DOMNode $div, string $assetFolderPath) : string
    {
        $node = $xpath->query(".//span[contains(@class, 'answer-description')]", $div)->item(0);

        $images = $xpath->query(".//img", $node);

        foreach ($images as $image) {
            // Obtener el valor actual del atributo src
            $src = $image->getAttribute("src");

            // Utilizar expresiones regulares para extraer el nombre de archivo de la URL original
            $fileName = basename($src);

            // Concatenar el nuevo directorio con el mismo nombre de archivo
            $newSrc = $assetFolderPath . '/' .$fileName;

            // Reemplazar el atributo src por el nuevo valor deseado
            $image->setAttribute("src", $newSrc);
        }

        $answer_description = $node->ownerDocument->saveHTML($node);

        $answer_description = str_replace("amp;","", $answer_description);

        $answer_description = str_replace("\n","", $answer_description);

        $answer_description = preg_replace('/ {3,}/', ' ', $answer_description);

        $answer_description = str_replace('"', "'", $answer_description);

        $answer_description = base64_encode($answer_description);

        return  $answer_description;
    }

    private function loadQuestionComments(DOMXPath $xpath, DOMNode $div) : array
    {
        $comments = [];

        $comments_div = $xpath->query(".//div[contains(@class, 'media-body')]", $div);

        foreach ($comments_div as $comment_div) {

            $badge = $xpath->query(".//span[contains(@class, 'badge')]", $comment_div)->item(0);

            if ($badge) {

                $comment = [];

                $comment['username'] = trim($xpath->query(".//h5[contains(@class, 'comment-username')]", $comment_div)->item(0)->textContent);

                $comment['comment_text'] = trim($xpath->query(".//div[contains(@class, 'comment-content')]", $comment_div)->item(0)->textContent);

                $comment['badge'] = trim($badge->textContent);

                $comment['date'] = trim($xpath->query(".//span[contains(@class, 'comment-date')]", $comment_div)->item(0)->textContent);

                $comments[] = $comment;

            }
        }

        return $comments;
    }
}