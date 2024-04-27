<?php

namespace App\Repository;

use App\Models\Question;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class QuestionRepositoryImpl implements IQuestionRepository
{
    public function createQuestion($questionDetails) : Question|null
    {

        try {

            $question = new Question();

            $question->question_number = $questionDetails["question_number"];

            $question->topic_id = $questionDetails["topic_id"];

            $question->exam_id = $questionDetails["exam_id"];

            $question->question_text = $questionDetails["question_text"];

            if (isset($questionDetails["choices"])){

                $question->choices = $questionDetails["choices"];

            }

            $question->solution = $questionDetails["solution"];

            $question->solution_description = $questionDetails["solution_description"];

            $question->save();

            return $question;

        } catch (Exception $e) {

            return null;

        }

    }

    public function getAllQuestionsByExamId(int $examId): Collection|Question|null
    {

        try {

            $questions = Question::where("exam_id", $examId)->get();

            return $questions;

        } catch (Exception $e) {

            return null;

        }

    }

    public function getQuestionByExamIdAndQuestionId(int $examId, int $questionId): Question|null
    {

        try {

            $questions = Question::where("exam_id", $examId)->where("id", $questionId)->get()[0];

            return $questions;

        } catch (Exception $e) {

            return null;

        }

    }

    public function getAllQuestionsByExamIdAndTopicId(int $examId, int $topicId) : Collection|Question|null
    {

        try {

            $questions = Question::where("exam_id", $examId)->where("topic_id", $topicId)->get();

            return $questions;

        } catch (Exception $e) {

            return null;

        }

    }

    public function getAllQuestionsByExamIdAndTopicIdAndQuestionNumber(int $examId, int $topicId, int $questionNumber) : Question|null
    {

        try {

            $questions = Question::where("exam_id", $examId)->where("topic_id", $topicId)->where("question_number", $questionNumber)->get()[0];

            return $questions;

        } catch (Exception $e) {

            return null;

        }

    }

}