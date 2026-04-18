<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Act extends Model
{
    protected $fillable = [
        'chapter_id',
        'title',
        'order_number',
    ];

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function lesson(): HasOne
    {
        return $this->hasOne(Lesson::class);
    }
}
