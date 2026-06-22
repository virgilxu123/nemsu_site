<?php

namespace App\Models;

use App\Concerns\Searchable;
use App\Concerns\Sortable;
use Database\Factories\JobOpportunityFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['id', 'name', 'slug', 'content', 'date', 'is_hiring', 'is_published'])]
class JobOpportunity extends Model
{
    /** @use HasFactory<JobOpportunityFactory> */
    use HasFactory, HasUuids, Searchable, Sortable;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $attributes = [
        'is_hiring' => false,
        'is_published' => false,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'is_hiring' => 'boolean',
            'is_published' => 'boolean',
        ];
    }
}
