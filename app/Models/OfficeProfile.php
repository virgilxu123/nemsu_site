<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['office_id', 'parent_office_id', 'vp_cluster', 'short_background', 'unit_head', 'email', 'phone', 'address', 'services', 'status', 'is_published', 'published_at'])]
class OfficeProfile extends Model
{
    use HasUuids;

    protected $attributes = [
        'status' => 'draft',
        'is_published' => false,
    ];

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function parentOffice(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'parent_office_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'services' => 'array',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }
}
