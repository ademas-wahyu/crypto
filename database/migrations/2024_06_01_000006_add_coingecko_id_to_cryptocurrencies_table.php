<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cryptocurrencies', function (Blueprint $table) {
            $table->string('coingecko_id')->nullable()->after('symbol');
            $table->index('coingecko_id');
        });
    }

    public function down(): void
    {
        Schema::table('cryptocurrencies', function (Blueprint $table) {
            $table->dropIndex(['coingecko_id']);
            $table->dropColumn('coingecko_id');
        });
    }
};
