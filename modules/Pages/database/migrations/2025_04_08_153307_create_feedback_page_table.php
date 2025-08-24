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
        Schema::create('feedback_page', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feedback_id');
            $table->unsignedBigInteger('page_id');
            $table->smallInteger('sort_order')->default(100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_page');
    }
};
