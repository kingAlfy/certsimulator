<?php

namespace App\Repository;

use App\Models\Comment;

interface ICommentRepository
{
    public function createCommentForQuestion(array $commentDetails) : Comment|null;
}