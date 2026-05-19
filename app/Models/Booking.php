<?php

namespace App\Models;

use App\Notifications\BookingCreatedNotification;
use App\Notifications\BookingStatusChangedNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'customer_id',
        'provider_id',
        'scheduled_at',
        'status',
        'price',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($booking) {
            // Notify provider when a new booking is created
            $booking->provider->notify(new BookingCreatedNotification($booking));
        });

        static::updated(function ($booking) {
            // Notify customer when booking status changes
            if ($booking->isDirty('status')) {
                $oldStatus = $booking->getOriginal('status');
                $newStatus = $booking->status;
                $booking->customer->notify(new BookingStatusChangedNotification($booking, $oldStatus, $newStatus));
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
