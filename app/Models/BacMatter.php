<?php

namespace App\Models;

use App\Concerns\Searchable;
use App\Concerns\Sortable;
use Database\Factories\BacMatterFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'file', 'link', 'type', 'date', 'is_published'])]
class BacMatter extends Model
{
    /** @use HasFactory<BacMatterFactory> */
    use HasFactory, Searchable, Sortable;

    protected $attributes = [
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
            'is_published' => 'boolean',
        ];
    }
}
