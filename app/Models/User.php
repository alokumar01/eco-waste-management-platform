<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'status',
    'provider_status',
    'business_name',
    'phone',
    'service_area',
    'address',
    'bio',
    'approved_at',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_USER = 'user';

    public const ROLE_PROVIDER = 'provider';

    public const ROLE_ADMIN = 'admin';

    public const PROVIDER_PENDING = 'pending';

    public const PROVIDER_APPROVED = 'approved';

    public const PROVIDER_REJECTED = 'rejected';

    /**
     * @return HasMany<CompostingService, $this>
     */
    public function compostingServices(): HasMany
    {
        return $this->hasMany(CompostingService::class, 'provider_id');
    }

    public function isProvider(): bool
    {
        return $this->role === self::ROLE_PROVIDER;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function hasApprovedProviderProfile(): bool
    {
        return $this->isProvider() && $this->provider_status === self::PROVIDER_APPROVED;
    }

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
            'approved_at' => 'datetime',
        ];
    }
}
