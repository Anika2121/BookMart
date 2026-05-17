<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->unsignedInteger('view_count')->default(0)->after('status');
            $table->unsignedInteger('order_count')->default(0)->after('view_count');
            $table->decimal('score', 8, 4)->default(0)->after('order_count');
            $table->boolean('is_featured')->default(false)->after('score');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['view_count', 'order_count', 'score', 'is_featured']);
        });
    }
};