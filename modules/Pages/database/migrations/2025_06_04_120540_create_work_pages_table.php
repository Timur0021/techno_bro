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
        Schema::create('work_pages', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->longText('content_left')->nullable();
            $table->longText('content_right')->nullable();
            $table->timestamps();
        });

        Schema::create('work_work_pages', function (Blueprint $table) {
            $table->unsignedBigInteger('work_id')->nullable()->index();
            $table->unsignedBigInteger('work_page_id')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_pages');
        Schema::dropIfExists('work_work_pages');
    }
};
