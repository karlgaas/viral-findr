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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('inputUrl',1000)->nullable();
            $table->string('id_no')->nullable();
            $table->string('type')->nullable();
            $table->string('caption')->nullable();
            $table->string('url',1000)->nullable();
            $table->string('commentsCount')->nullable();
            $table->string('displayUrl',1000)->nullable();
            $table->string('likesCount')->nullable();
            $table->string('videoViewCount')->nullable();
            $table->string('videoUrl',1000)->nullable();
            $table->string('videoPlayCount')->nullable();
            $table->string('ownerFullName')->nullable();
            $table->string('ownerUsername')->nullable();
            $table->string('ownerId')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('search_id')->nullable()->constrained('searches');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
