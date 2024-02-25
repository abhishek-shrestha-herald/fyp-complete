<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Panel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;


class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Filament methods

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->profile_photo_path ? Storage::url($this->profile_photo_path) : null;
    }

}
