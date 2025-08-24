<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->dropColumn('author_id');
            $table->dropColumn('view_count');
            $table->dropColumn('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('author_id')->nullable()->index();
            $table->integer('view_count')->default(0);
            $table->timestamp('published_at')->nullable();
        });
    }
};
