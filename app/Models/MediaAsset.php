<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['disk', 'path', 'url', 'title', 'alt_text', 'mime_type', 'size', 'legacy_path', 'is_published', 'metadata'])]
class MediaAsset extends Model
{
    use HasUuids;

    protected $attributes = [
        'disk' => 'public',
        'is_published' => true,
    ];

    public function programDetails(): HasMany
    {
        return $this->hasMany(ProgramDetail::class, 'prospectus_file_id');
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
            'metadata' => 'array',
        ];
    }
}
