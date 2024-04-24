<?php

namespace App\Repository;
use App\Models\Comment;

class CommentRepositoryImpl implements ICommentRepository
{
    public function createCommentForQuestion($commentDetails): Comment|null
    {
        try {

            $comment = new Comment();

            $comment->question_id = $commentDetails['question_id'];

            $comment->username = $commentDetails['username'];

            $comment->comment_text = $commentDetails['comment_text'];

            $comment->date = $commentDetails['date'];

            $comment->badge = $commentDetails['badge'];

            $comment->save();

            return $comment;

        } catch (\Exception $e) {

            return null;

        }

    }
}