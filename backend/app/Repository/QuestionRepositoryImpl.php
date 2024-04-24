<?php

namespace App\Repository;

use App\Models\Question;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class QuestionRepositoryImpl implements IQuestionRepository
{
    public function createQuestion($questionDetails) : Question|null|string
    {

        try {

            $question = new Question();

            $question->question_number = $questionDetails["question_number"];

            $question->topic_id = $questionDetails["topic_id"];

            $question->exam_id = $questionDetails["exam_id"];

            $question->question_text = $questionDetails["question_text"];

            if (isset($choices)){
                $question->choices = $questionDetails["choices"];
            }

            $question->solution = $questionDetails["solution"];

            $question->solution_description = $questionDetails["solution_description"];

            $question->save();

            return $question;

        } catch (Exception $e) {

            return $e->getMessage();

        }

    }

    public function getAllQuestionsByExam(int $examId): Collection|Question|null
    {
        try {

            $questions = Question::where("exam_id", $examId)->get();

            return $questions;

        } catch (Exception $e) {

            return null;

        }

    }
}