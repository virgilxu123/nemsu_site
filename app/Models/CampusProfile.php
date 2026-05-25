<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['campus_id', 'director', 'contact_details', 'facilities', 'services', 'campus_life', 'student_government', 'status', 'is_published', 'published_at'])]
class CampusProfile extends Model
{
    use HasUuids;

    protected $attributes = [
        'status' => 'draft',
        'is_published' => false,
    ];

    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'contact_details' => 'array',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }
}
