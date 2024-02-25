<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $with = [
        'orderItems', 'paymentRecord'
    ];

    protected $fillable = [
        'farmer_id',
        'total',
        'currency',
        'status',
    ];

    protected $casts = [
        'currency' => Currency::class,
        'status' => OrderStatus::class,
    ];

    // Booted

    public static function booted()
    {
        self::creating(function(Order $order){
            $order->currency = Currency::NPR;
        });
    }

    // Relationships

    public function farmer() {
        return $this->belongsTo(Farmer::class);
    }

    public function paymentRecord()
    {
        return $this->hasOne(PaymentRecord::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

}
