<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // enable UUID extension
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp"');
        Schema::create('files', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('uuid_generate_v4()'));
            $table->string('name');
            $table->string('mime', 64)->nullable();
            $table->string('extension', 8)->nullable();
            $table->unsignedBigInteger('size');
            $table->string('path');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');

            $table->string('checksum_sha256', 64)->nullable();
            $table->boolean('is_success_uploaded')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
