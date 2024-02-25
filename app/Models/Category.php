<?php

namespace App\Models;

use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cover_image_id'
    ];

    // Relationships

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function coverImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'cover_image_id', 'id');
    }

}
