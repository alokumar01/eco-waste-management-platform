<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('category')->nullable();
            $table->text('description'); // short description
            $table->text('detailed_description')->nullable();
            $table->string('type')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('unit')->nullable();
            $table->string('duration')->nullable();
            $table->text('what_we_accept')->nullable();
            $table->text('what_we_dont_accept')->nullable();
            $table->string('city')->nullable();
            $table->string('additional_areas')->nullable();
            $table->string('image_path')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
