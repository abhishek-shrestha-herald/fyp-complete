<?php

namespace App\Models;

use App\Enums\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $with = [
        'product'
    ];

    protected $fillable = [
        'order_id',
        'product_id',
        'unit_price',
        'total_price',
        'currency',
        'quantity',
        'unit_id',
    ];

    protected $casts = [
        'currency' => Currency::class,
    ];

    // Relationships

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // public function farmer()
    // {
    //     return $this->hasOneThrough(
    //         Farmer::class,
    //         Order::class,
    //         'id',
    //         'id',
    //         'order_id',
    //         'farmer_id'
    //     );
    // }
}
