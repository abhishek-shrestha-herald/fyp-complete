<?php

namespace App\Models;

use App\Enums\Currency;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Jackiedo\Cart\Contracts\UseCartable;
use Jackiedo\Cart\Traits\CanUseCart;
use Laravel\Scout\Searchable;

class Product extends Model implements UseCartable
{
    use HasFactory;
    use CanUseCart;
    use Searchable;

    protected $cartTitleField = 'name';        // Your correctly field for product's title
    protected $cartPriceField = 'unit_price';  // Your correctly field for product's price

    protected $with = [
        'category', 'unit', 'coverImage', 'images'
    ];

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'unit_price',
        'currency',
        'available_quantity',
        'unit_id',
        'cover_image_id'
    ];

    protected $casts = [
        'currency' => Currency::class,
    ];

    // Searching
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'description' => $this->description,
        ];
    }

    // Relationships

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function images(): BelongsToMany
    {
        return $this
            ->belongsToMany(Media::class, 'media_product', 'product_id', 'media_id')
            ->withPivot('order')
            ->orderBy('order');
    }

    public function coverImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'cover_image_id', 'id');
    }
}
