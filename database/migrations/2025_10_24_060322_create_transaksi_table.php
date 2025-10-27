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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->foreignId('kasir_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->decimal('total_harga', 12, 2);
            $table->decimal('diskon', 12, 2)->default(0);
            $table->decimal('keuntungan', 12, 2)->default(0);
            $table->enum('metode_pembayaran', ['tunai', 'transfer', 'qris'])->default('tunai');
            $table->enum('status', ['pending', 'selesai', 'dibatalkan'])->default('selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
