<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['slug', 'title', 'section', 'body', 'excerpt', 'status', 'is_published', 'published_at', 'office_id', 'campus_id', 'legacy_table', 'legacy_id', 'sort_order'])]
class ContentPage extends Model
{
    use HasUuids;

    protected $attributes = [
        'status' => 'draft',
        'is_published' => false,
        'sort_order' => 0,
    ];

    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }
}
