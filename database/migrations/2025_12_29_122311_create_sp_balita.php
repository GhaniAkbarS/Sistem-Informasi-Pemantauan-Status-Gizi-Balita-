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
        Schema::create('sp_balita', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jk', ['L', 'P']);
            $table->string('nama_ortu');
            $table->date('tgl_lahir');
            $table->integer('umur');
            $table->double('tinggi_badan');
            $table->double('berat_badan');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp_balita');
    }
};
