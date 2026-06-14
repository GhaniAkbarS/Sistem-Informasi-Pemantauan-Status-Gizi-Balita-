<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel sesi pengujian
        Schema::create('usability_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penguji');         // Nama kader / penguji
            $table->string('peran')->default('kader'); // kader / admin / dll
            $table->timestamp('mulai_at');
            $table->timestamp('selesai_at')->nullable();
            $table->integer('durasi_detik')->nullable(); // Total durasi sesi
            $table->string('token')->unique();       // Token unik sesi
            $table->timestamps();
        });

        // Tabel log event per sesi
        Schema::create('usability_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usability_session_id')->constrained()->onDelete('cascade');
            $table->string('event_type');    // page_visit, click, form_submit, error, back_navigation
            $table->string('page_url');      // URL halaman saat event terjadi
            $table->string('page_name')->nullable(); // Nama halaman (misal: "Tambah Balita")
            $table->string('element')->nullable();   // Element yang diklik (tombol, link)
            $table->integer('durasi_di_halaman')->nullable(); // Durasi di halaman (detik)
            $table->boolean('is_back_navigation')->default(false); // Apakah kembali ke halaman sebelumnya?
            $table->boolean('is_error')->default(false);           // Apakah event error?
            $table->text('catatan')->nullable();
            $table->timestamp('terjadi_at');
            $table->timestamps();
        });

        // Tabel hasil per skenario
        Schema::create('usability_task_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usability_session_id')->constrained()->onDelete('cascade');
            $table->integer('task_number');         // Nomor skenario (1, 2, 3, 4)
            $table->string('task_name');            // Nama skenario
            $table->boolean('berhasil')->default(false);
            $table->integer('durasi_detik')->nullable(); // Waktu penyelesaian tugas
            $table->integer('jumlah_error')->default(0); // Jumlah klik salah / balik
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usability_task_results');
        Schema::dropIfExists('usability_logs');
        Schema::dropIfExists('usability_sessions');
    }
};
