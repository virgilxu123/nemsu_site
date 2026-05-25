<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['id', 'name', 'slug', 'description'])]
class Campus extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    public function contentPages(): HasMany
    {
        return $this->hasMany(ContentPage::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(CampusProfile::class);
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }

    public function siteMetrics(): HasMany
    {
        return $this->hasMany(SiteMetric::class);
    }
}
