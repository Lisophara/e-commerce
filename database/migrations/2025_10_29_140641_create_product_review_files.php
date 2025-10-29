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
        Schema::create('product_review_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_review_id');
            $table->foreign('product_review_id')->references('id')->on('product_reviews')
                ->onDelete('cascade');
            $table->uuid('file_id');
            $table->foreign('file_id')->references('id')->on('files')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_review_files');
    }
};
