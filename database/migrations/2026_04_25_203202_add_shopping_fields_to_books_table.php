<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('isbn', 20)->nullable()->after('author');
            $table->string('publisher')->nullable()->after('isbn');
            $table->string('language')->default('Bangla')->after('publisher');
            $table->integer('pages')->nullable()->after('language');
            $table->year('published_year')->nullable()->after('pages');
            $table->text('sample_pages')->nullable()->after('published_year');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn([
                'isbn',
                'publisher',
                'language',
                'pages',
                'published_year',
                'sample_pages',
            ]);
        });
    }
};