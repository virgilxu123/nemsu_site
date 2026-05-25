<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description', 'type', 'office_id', 'date', 'is_published'])]
class Gallery extends Model
{
    protected $attributes = [
        'type' => 'event',
        'is_published' => false,
    ];

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class);
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
        ];
    }
}
