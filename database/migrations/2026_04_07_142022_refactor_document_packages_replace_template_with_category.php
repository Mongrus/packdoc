<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('document_packages', function (Blueprint $table) {
            $table->dropForeign(['template_id']);
            $table->dropColumn('template_id');

            $table->string('name')->after('user_id');
            $table->foreignId('category_id')->after('name')->constrained('document_categories')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('document_packages', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['name', 'category_id']);

            $table->foreignId('template_id')->constrained('document_templates')->cascadeOnDelete();
        });
    }
};
