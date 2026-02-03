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
        Schema::create('sp_periksa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('balita_id')->constrained('sp_balita')->onDelete('cascade');
            $table->date('tgl_lahir');
            $table->unsignedTinyInteger('umur_bulan');
            $table->string('nama_ortu');
            $table->date('tanggal_periksa');
            $table->decimal('berat_badan', 4, 1);
            $table->decimal('tinggi_badan', 5, 1);
            $table->enum('jenis_pengukuran', ['PB', 'TB']);
            $table->enum('status_gizi', [
                'Stunting',
                'Gizi Kurang',
                'Gizi Normal',
                'Gizi Lebih'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp_periksa');
    }
};
