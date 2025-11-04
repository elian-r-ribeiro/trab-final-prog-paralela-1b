<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionOption extends Model
{

    protected $table = 'questions_options';

    protected $fillable = [
        'text',
        'image',
        'is_correct',
        'quiz_id'
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
