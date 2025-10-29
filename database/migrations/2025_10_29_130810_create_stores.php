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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_slug')->unique();
            $table->string('address')->nullable();

            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->uuid('profile')->nullable();
            $table->foreign('profile')->references('id')->on('files')
                ->onUpdate('cascade')->onDelete('no action');
            $table->uuid('cover')->nullable();
            $table->foreign('cover')->references('id')->on('files')
                ->onUpdate('cascade')->onDelete('no action');

            $table->string('contact')->nullable();
            $table->string('fb_link')->nullable();
            $table->string('ig_link')->nullable();
            $table->string('tlg_link')->nullable();
            $table->string('twitter_link')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
