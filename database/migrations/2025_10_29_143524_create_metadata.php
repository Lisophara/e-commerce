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
        Schema::create('metadata', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('stores');

            $table->string('name');
            $table->string('name_slug');
            $table->string('group');
            $table->string('group_slug');

            $table->unique(['store_id', 'group_slug']);
            $table->unique(['group_slug', 'name_slug']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metadata');
    }
};
