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
        Schema::create('sp_imunisasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('balita_id')->constrained('sp_balita')->onDelete('cascade');
            $table->enum('nama_vaksin', [
                'HB0',
                'BCG', 'Polio 1',
                'DPT-HB-Hib 1', 'Polio 2',
                'DPT-HB-Hib 2', 'Polio 3',
                'DPT-HB-Hib 3', 'Polio 4', 'IPV',
                'Campak/MR',
                'DPT-HB-Hib 4', 'Campak/MR Lanjutan',
            ]);
            $table->date('tanggal_pemberian');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp_imunisasi');
    }
};
