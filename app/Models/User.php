<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUlids;


    // === Role Constants ===
    public const ROLE_SUPER_ADMIN = 'super_admin';
    public const ROLE_STORE_ADMIN = 'store_admin';
    public const ROLE_STORE_STAFF = 'store_staff';


    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'store_id',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // === Role Helpers ===
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isStoreAdmin(): bool
    {
        return $this->role === self::ROLE_STORE_ADMIN;
    }

    public function isStaff(): bool
    {
        return $this->role === self::ROLE_STORE_STAFF;
    }

    // Relationships
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function stores()
    {
        return $this->hasMany(Store::class, 'owner_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
