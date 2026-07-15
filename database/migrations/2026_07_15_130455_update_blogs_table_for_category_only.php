<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add category if it does not exist yet.
        if (! Schema::hasColumn('blogs', 'category')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->string('category')
                    ->nullable()
                    ->after('title');
            });
        }

        // Remove tags if it was already added before.
        if (Schema::hasColumn('blogs', 'tags')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->dropColumn('tags');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('blogs', 'category')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }
    }
};