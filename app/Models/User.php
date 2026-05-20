<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'business_name',
        'business_address',
        'phone_number',
        'profile_picture',
        'verification_document',
        'bio',
        'is_verified',
        'profile_completed',
        'city',
        'state',
        'pincode',
        'country',
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

    /**
     * Get the services for the user.
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function customerBookings()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    public function providerBookings()
    {
        return $this->hasMany(Booking::class, 'provider_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'provider_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function savedProviders()
    {
        return $this->belongsToMany(User::class, 'saved_providers', 'user_id', 'provider_id')->withTimestamps();
    }

    public function savedByCustomers()
    {
        return $this->belongsToMany(User::class, 'saved_providers', 'provider_id', 'user_id')->withTimestamps();
    }

    /**
     * Get the average rating for the provider.
     */
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    /**
     * Get the total review count for the provider.
     */
    public function reviewCount()
    {
        return $this->reviews()->count();
    }
}