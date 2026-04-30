<?php

use App\Models\CompostingService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('composting_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->index();
            $table->text('description');
            $table->string('location');
            $table->unsignedSmallInteger('service_radius_km')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('unit')->default('service');
            $table->unsignedInteger('capacity_kg_per_week')->nullable();
            $table->text('availability')->nullable();
            $table->string('approval_status')->default(CompostingService::STATUS_DRAFT)->index();
            $table->text('approval_notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_published')->default(false)->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['provider_id', 'approval_status']);
            $table->index(['approval_status', 'is_published']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('composting_services');
    }
};
