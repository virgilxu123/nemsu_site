<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['id', 'code', 'name', 'slug', 'banner', 'description'])]
class College extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}
