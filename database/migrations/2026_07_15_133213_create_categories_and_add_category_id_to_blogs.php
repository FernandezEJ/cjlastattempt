<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Create categories table
        |--------------------------------------------------------------------------
        */
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | Add category_id to blogs table
        |--------------------------------------------------------------------------
        */
        Schema::table('blogs', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->nullable()
                ->after('user_id')
                ->constrained('categories')
                ->nullOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Add default categories
        |--------------------------------------------------------------------------
        */
        DB::table('categories')->insert([
            [
                'name' => 'Action',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Adventure',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Comedy',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Drama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fantasy',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Horror',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Romance',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Science Fiction',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sports',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Other',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });

        Schema::dropIfExists('categories');
    }
};