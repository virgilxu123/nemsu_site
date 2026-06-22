<?php

namespace App\Models;

use App\Concerns\Searchable;
use App\Concerns\Sortable;
use Database\Factories\ProgramFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['code', 'name', 'loa', 'prospectus', 'description', 'college_id', 'campus_id', 'degree_program', 'is_archived'])]
class Program extends Model
{
    /** @use HasFactory<ProgramFactory> */
    use HasFactory, Searchable, Sortable;

    protected $attributes = [
        'degree_program' => 'baccalaureate',
        'is_archived' => false,
    ];

    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function detail(): HasOne
    {
        return $this->hasOne(ProgramDetail::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_archived' => 'boolean',
        ];
    }
}
