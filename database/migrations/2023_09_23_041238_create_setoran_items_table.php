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
        Schema::create('setoran_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setoran_id')
                ->constrained('setorans')
                ->cascadeOnDelete();
            $table->foreignId('jenis_sampah_id')
                ->constrained('jenis_sampahs')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setoran_items');
    }
};
