<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id ',
        'username',
        'comment_text',
        'date',
        'badge',
    ];

    /**
     * Indica si las IDs son autoincrementales.
     *
     * @var bool
     */
    public $incrementing = true;


    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
