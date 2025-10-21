<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('cryptocurrency_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 20, 8);
            $table->decimal('average_buy_price', 20, 8);
            $table->decimal('total_invested', 20, 8);
            $table->decimal('current_value', 20, 8)->nullable();
            $table->decimal('profit_loss', 20, 8)->nullable();
            $table->decimal('profit_loss_percent', 10, 4)->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'cryptocurrency_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};