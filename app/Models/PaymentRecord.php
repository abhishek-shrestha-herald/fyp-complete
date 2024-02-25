<?php

namespace App\Models;

use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Enums\Currency;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentRecord extends Model
{
    use HasFactory;

    protected $with = [
        // 'order',
        // 'user'
    ];

    protected $fillable = [
        'code',
        'user_id',
        'order_id',
        'provider',
        'currency',
        'amount',
        'status',
        'details',
        'transferred_to_wallet',
        'initiate_response',
        'redirect_response',
        'validate_response',
    ];

    protected $casts = [
        'provider' => PaymentProvider::class,
        'status' => PaymentStatus::class,
        'currency' => Currency::class,
        'details' => 'array',
        'transferred_to_wallet' => 'boolean',
        'initiate_response' => 'array',
        'redirect_response' => 'array',
        'validate_response' => 'array',
    ];

    // Booted

    public static function booted()
    {
        static::creating(function(PaymentRecord $record){
            $record->code =Str::random(20);

            if(is_null($record->details))
            {
                $record->details = [];
            }

            if(is_null($record->initiate_response))
            {
                $record->initiate_response = [];
            }

            if(is_null($record->redirect_response))
            {
                $record->redirect_response = [];
            }

            if(is_null($record->validate_response))
            {
                $record->validate_response = [];
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Farmer::class, 'user_id', 'id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
