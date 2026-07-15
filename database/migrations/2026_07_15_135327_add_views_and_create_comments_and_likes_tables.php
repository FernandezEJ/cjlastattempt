<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add view count to blogs.
        Schema::table('blogs', function (Blueprint $table) {
            $table->unsignedBigInteger('views')
                ->default(0)
                ->after('status');
        });

        // Create comments table.
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('blog_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->text('comment');

            $table->timestamps();
        });

        // Create blog likes table.
        Schema::create('blog_likes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('blog_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

            // One user can like a blog only once.
            $table->unique(['blog_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_likes');
        Schema::dropIfExists('comments');

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('views');
        });
    }
};