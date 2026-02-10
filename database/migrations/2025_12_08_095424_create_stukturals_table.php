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
        Schema::create('stukturals', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('unit', 100);
            $table->string('jabatan', 100);
            $table->string('name', 100);
            $table->string('photo', 255);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stukturals');
    }
};
