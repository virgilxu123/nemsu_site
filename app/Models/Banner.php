<?php

namespace App\Models;

use App\Concerns\Searchable;
use App\Concerns\Sortable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['photo', 'link', 'title', 'content', 'office_id', 'is_published', 'sequence'])]
class Banner extends Model
{
    use HasFactory, Searchable, Sortable;

    protected $attributes = [
        'is_published' => false,
        'sequence' => 0,
    ];

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
            'sequence' => 'integer',
        ];
    }
}
