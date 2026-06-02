<?php

namespace App\Models;

use App\Concerns\Searchable;
use App\Concerns\Sortable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['id', 'title', 'slug', 'short_description', 'content', 'photo', 'author', 'office_id', 'type', 'is_published', 'featured', 'date'])]
class News extends Model
{
    use HasFactory, HasUuids, Searchable, Sortable;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $attributes = [
        'type' => 'news',
        'featured' => false,
    ];

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(NewsView::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'is_published' => 'boolean',
            'featured' => 'boolean',
        ];
    }
}
