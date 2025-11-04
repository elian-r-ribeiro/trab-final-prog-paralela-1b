<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Quiz extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'type',
        'discipline_id'
    ];

    public function discipline(): BelongsTo
    {
        return $this->belongsTo(Discipline::class);
    }

    public function feedback(): HasOne
    {
        return $this->hasOne(Feedback::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }
}
