<?php

namespace App\Models;

use Database\Factories\CollegeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['id', 'code', 'name', 'slug', 'banner', 'description'])]
class College extends Model
{
    /** @use HasFactory<CollegeFactory> */
    use HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}
