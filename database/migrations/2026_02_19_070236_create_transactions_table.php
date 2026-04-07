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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_nota')->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('serpice_id')->constrained('serpices')->onDelete('cascade');
            $table->date('tanggal_masuk');
            $table->date('tanggal_selesai');
            $table->date('tanggal_ambil')->nullable();
            $table->decimal('berat_kg', 8, 2);
            $table->decimal('total_harga', 15, 2);
            $table->enum('status', ['Proses', 'Selesai', 'Diambil'])->default('Proses');
            $table->enum('status_bayar', ['Lunas', 'Belum Lunas', 'DP'])->default('Belum Lunas');
            $table->decimal('jumlah_bayar', 15, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};