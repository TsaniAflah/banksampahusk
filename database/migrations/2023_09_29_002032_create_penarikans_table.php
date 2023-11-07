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
        Schema::create('penarikans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->default(now());
            $table->decimal('jumlah_penarikan', 12, 2)->default(0);
            $table->enum('status', ['diterima', 'ditolak', 'waiting'])->default('waiting');
            $table->date('tanggal_persetujuan')->nullable();
            $table->string('bukti_transfer')->nullable();
            $table->text('keterangan')->nullable();

            $table->unsignedBigInteger('user_id')->nullable()->default(1);
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penarikans');
    }
};
