<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [
        'id'
    ];

    /**
     * Get the full URL for the company image.
     *
     * @return string|null
     */
    public function getCompanyImageUrlAttribute()
    {
        return $this->company_image ? Storage::url($this->company_image) : null;
    }
}