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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('product_id2')->nullable(true)->change();
            $table->integer('num2')->nullable(true)->change();
            $table->foreignId('product_id3')->nullable(true)->change();
            $table->integer('num3')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('product_id2')->nullable(false)->change();
            $table->integer('num2')->nullable(false)->change();
            $table->foreignId('product_id3')->nullable(false)->change();
            $table->integer('num3')->nullable(false)->change();
        });
    }
};
