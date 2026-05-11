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
        Schema::create('sp_vitamin_a', function (Blueprint $table) {
            $table->id();
            $table->foreignId('balita_id')->constrained('sp_balita')->onDelete('cascade');
            $table->enum('jenis_kapsul', ['Biru (100.000 IU)', 'Merah (200.000 IU)']);
            $table->enum('bulan_pemberian', ['Februari', 'Agustus']);
            $table->year('tahun_pemberian');
            $table->date('tanggal_pemberian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp_vitamin_a');
    }
};
