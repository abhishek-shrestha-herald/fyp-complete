<?php

namespace App\Models;

use App\Enums\FarmerType;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class Farmer extends User implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'last_login_at',
        'email_verified_at',
        'wishlist'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'wishlist' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // Booted method

    public static function booted()
    {
        self::creating(function (Farmer $farmer) {
            if (is_null($farmer->wishist)) {
                $farmer->wishlist = [];
            }
        });
    }


    // Wishlist

    public function addToWishList(Product $product): bool
    {
        if (in_array($product->id, $this->wishlist ?? [])) {
            return true;
        }
        $this->wishlist = array_merge(
            $this->wishlist ?? [],
            [
                $product->id
            ]
        );

        return $this->save();
    }

    public function removeFromWishList(Product $product): bool
    {
        if (!in_array($product->id, $this->wishlist ?? [])) {
            return true;
        }
        $this->wishlist = array_filter($this->wishlist, function ($value, $key) use ($product) {
            return $value != $product->id;
        }, ARRAY_FILTER_USE_BOTH);

        return $this->save();
    }

    // Relationships

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
