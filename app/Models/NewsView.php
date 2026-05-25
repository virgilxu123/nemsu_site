<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['id', 'news_id', 'views'])]
class NewsView extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $attributes = [
        'views' => 0,
    ];

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }
}
