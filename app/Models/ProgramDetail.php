<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['program_id', 'objectives', 'learning_outcomes', 'curriculum', 'prospectus_file_id', 'admission_requirements', 'status', 'is_published', 'published_at'])]
class ProgramDetail extends Model
{
    use HasUuids;

    protected $attributes = [
        'status' => 'draft',
        'is_published' => false,
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function prospectusFile(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'prospectus_file_id');
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
