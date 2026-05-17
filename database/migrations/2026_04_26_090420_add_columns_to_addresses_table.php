<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
            $table->string('label')->after('user_id');
            $table->string('recipient_name')->after('label');
            $table->string('phone', 20)->after('recipient_name');
            $table->text('address_line')->after('phone');
            $table->string('city')->after('address_line');
            $table->string('district')->after('city');
            $table->string('postal_code', 10)->nullable()->after('district');
            $table->boolean('is_default')->default(false)->after('postal_code');
        });
    }

    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id', 'label', 'recipient_name', 'phone',
                'address_line', 'city', 'district', 'postal_code', 'is_default'
            ]);
        });
    }
};