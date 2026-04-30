<?php

namespace Database\Factories;

use App\Models\CompostingService;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<CompostingService>
 */
class CompostingServiceFactory extends Factory
{
    protected $model = CompostingService::class;

    public function definition(): array
    {
        $title = fake()->words(4, true);

        return [
            'provider_id' => User::factory()->provider(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::random(6),
            'category' => fake()->randomElement(array_keys(CompostingService::categories())),
            'description' => fake()->paragraphs(3, true),
            'location' => fake()->city(),
            'service_radius_km' => fake()->numberBetween(5, 50),
            'price' => fake()->randomFloat(2, 250, 5000),
            'unit' => fake()->randomElement(['pickup', 'month', 'service']),
            'capacity_kg_per_week' => fake()->numberBetween(50, 2000),
            'availability' => fake()->sentence(),
            'approval_status' => CompostingService::STATUS_DRAFT,
            'is_published' => false,
        ];
    }

    public function pendingReview(): static
    {
        return $this->state(fn (array $attributes) => [
            'approval_status' => CompostingService::STATUS_PENDING,
            'is_published' => false,
            'published_at' => null,
        ]);
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'approval_status' => CompostingService::STATUS_APPROVED,
            'approved_at' => now(),
            'approved_by' => User::factory()->admin(),
        ]);
    }

    public function published(): static
    {
        return $this->approved()->state(fn (array $attributes) => [
            'is_published' => true,
            'published_at' => now(),
        ]);
    }
}
