<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['banner', 'code', 'name', 'slug', 'category', 'description', 'campus_id'])]
class Office extends Model
{
    public function banners(): HasMany
    {
        return $this->hasMany(Banner::class);
    }

    public function contentPages(): HasMany
    {
        return $this->hasMany(ContentPage::class);
    }

    public function downloadableFiles(): HasMany
    {
        return $this->hasMany(DownloadableFile::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(OfficeProfile::class);
    }
}
