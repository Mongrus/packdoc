<?php

use App\Enums\SubscriptionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('subscription_status', array_column(SubscriptionStatus::cases(), 'value'))
                ->default(SubscriptionStatus::Free->value)
                ->after('remember_token');
            $table->unsignedInteger('package_created_count')
                ->default(0)
                ->after('subscription_status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['subscription_status', 'package_created_count']);
        });
    }
};
