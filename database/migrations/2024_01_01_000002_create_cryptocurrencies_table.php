<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cryptocurrencies', function (Blueprint $table) {
            $table->id();
            $table->string('symbol', 20)->unique();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->decimal('current_price', 20, 8);
            $table->decimal('market_cap', 30, 2)->nullable();
            $table->decimal('volume_24h', 30, 2)->nullable();
            $table->decimal('change_24h', 10, 4)->default(0);
            $table->decimal('change_percent_24h', 10, 4)->default(0);
            $table->json('historical_data')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('rank')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cryptocurrencies');
    }
};