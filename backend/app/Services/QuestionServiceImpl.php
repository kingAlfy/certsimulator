<?php

namespace App\Services;

use App\Models\Question;
use App\Repository\IQuestionRepository;
use Illuminate\Database\Eloquent\Collection;

class QuestionServiceImpl implements IQuestionService
{
    private IQuestionRepository $questionRepository;

    public function __construct(IQuestionRepository $questionRepository)
    {

        $this->questionRepository = $questionRepository;

    }

    public function getAllQuestionsByExam(int $examId): Collection|Question
    {

        return $this->questionRepository->getAllQuestionsByExamId($examId);

    }

    public function getQuestionByExamAndQuestion(int $examId, int $questionId): Question|null
    {

        $question = $this->questionRepository->getQuestionByExamIdAndQuestionId($examId, $questionId);

        if (!isset($question)){

            return null;

        }

        return $question;

    }

    public function getAllQuestionsByExamAndTopic(int $examId, int $topicId) : Collection|Question|null
    {

        $questions = $this->questionRepository->getAllQuestionsByExamIdAndTopicId($examId, $topicId);

        if(!isset($questions)){

            return null;

        }

        return $questions;

    }

// TODO: Refactor and delete 'All'
    public function getAllQuestionsByExamAndTopicAndQuestion(int $examId, int $topicId, int $questionNumber) : Question|null
    {

        $questions = $this->questionRepository->getAllQuestionsByExamIdAndTopicIdAndQuestionNumber($examId, $topicId, $questionNumber);

        if(!isset($questions)){

            return null;

        }

        return $questions;

    }

}