<?php

namespace App\Models;

use Database\Factories\CompostingServiceFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompostingService extends Model
{
    /** @use HasFactory<CompostingServiceFactory> */
    use HasFactory, SoftDeletes;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PENDING = 'pending_review';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_REJECTED = 'rejected';

    public const CATEGORY_COMPOSTING_PICKUP = 'composting_pickup';

    public const CATEGORY_BIN_SETUP = 'compost_bin_setup';

    public const CATEGORY_ORGANIC_COLLECTION = 'organic_waste_collection';

    public const CATEGORY_SOIL_AMENDMENT = 'soil_amendment';

    public const CATEGORY_CONSULTATION = 'consultation';

    protected $fillable = [
        'provider_id',
        'title',
        'slug',
        'category',
        'description',
        'location',
        'service_radius_km',
        'price',
        'unit',
        'capacity_kg_per_week',
        'availability',
        'approval_status',
        'approval_notes',
        'approved_at',
        'approved_by',
        'is_published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'approved_at' => 'datetime',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function canBePublished(): bool
    {
        return $this->approval_status === self::STATUS_APPROVED;
    }

    public function markAsNeedingReview(): void
    {
        $this->forceFill([
            'approval_status' => self::STATUS_PENDING,
            'approval_notes' => null,
            'approved_at' => null,
            'approved_by' => null,
            'is_published' => false,
            'published_at' => null,
        ]);
    }

    /**
     * @param  Builder<CompostingService>  $query
     * @return Builder<CompostingService>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('approval_status', self::STATUS_APPROVED)
            ->where('is_published', true);
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::get(fn (): string => match ($this->approval_status) {
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_PENDING => 'Pending review',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected',
            default => ucfirst(str_replace('_', ' ', (string) $this->approval_status)),
        });
    }

    public static function categories(): array
    {
        return [
            self::CATEGORY_COMPOSTING_PICKUP => 'Composting pickup',
            self::CATEGORY_BIN_SETUP => 'Compost bin setup',
            self::CATEGORY_ORGANIC_COLLECTION => 'Organic waste collection',
            self::CATEGORY_SOIL_AMENDMENT => 'Soil amendment supply',
            self::CATEGORY_CONSULTATION => 'Waste reduction consultation',
        ];
    }
}
