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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('type', allowed: ['شركة', 'فردي'])->default('فردي');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('industry')->nullable();
            $table->string('address')->nullable();
            $table->enum('status', ['فعال', 'غير فعال'])->default('فعال');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
