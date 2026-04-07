<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('document_packages', function (Blueprint $table) {
            $table->string('type')->after('user_id')->default('freelance');

            $table->dropForeign(['category_id']);
            $table->dropColumn(['name', 'category_id', 'file_path']);
        });
    }

    public function down(): void
    {
        Schema::table('document_packages', function (Blueprint $table) {
            $table->dropColumn('type');

            $table->string('name')->after('user_id');
            $table->foreignId('category_id')->after('name')->constrained('document_categories')->cascadeOnDelete();
            $table->string('file_path')->nullable();
        });
    }
};
