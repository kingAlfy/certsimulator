<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question_number',
        'topic_id',
        'exam_id',
        'question_text',
        'choices',
        'solution',
        'solution_description',
    ];

    /**
     * Indica si las IDs son autoincrementales.
     *
     * @var bool
     */
    public $incrementing = true;

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }


    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
