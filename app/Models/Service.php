<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'category',
        'description',
        'detailed_description',
        'type',
        'price',
        'unit',
        'duration',
        'what_we_accept',
        'what_we_dont_accept',
        'city',
        'additional_areas',
        'image_path',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getImagePathAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        if (str_starts_with($value, '[') && str_ends_with($value, ']')) {
            $images = json_decode($value, true);
            return !empty($images) ? $images[0] : null;
        }
        return $value;
    }

    public function getImagesAttribute()
    {
        $value = $this->attributes['image_path'] ?? null;
        if (empty($value)) {
            return [];
        }
        if (str_starts_with($value, '[') && str_ends_with($value, ']')) {
            return json_decode($value, true) ?: [];
        }
        return [$value];
    }
}
