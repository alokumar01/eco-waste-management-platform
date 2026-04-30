<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('provider_status')->nullable()->default(null)->after('status')->index();
            $table->string('business_name')->nullable()->after('provider_status');
            $table->string('phone', 30)->nullable()->after('business_name');
            $table->string('service_area')->nullable()->after('phone');
            $table->text('address')->nullable()->after('service_area');
            $table->text('bio')->nullable()->after('address');
            $table->timestamp('approved_at')->nullable()->after('bio');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index(['role', 'provider_status']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role', 'provider_status']);
            $table->dropColumn([
                'provider_status',
                'business_name',
                'phone',
                'service_area',
                'address',
                'bio',
                'approved_at',
            ]);
        });
    }
};
