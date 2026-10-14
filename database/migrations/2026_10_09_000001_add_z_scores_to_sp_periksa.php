<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sp_periksa', function (Blueprint $table) {
            $table->decimal('z_bbu', 6, 2)->nullable();
            $table->decimal('z_tbu', 6, 2)->nullable();
            $table->decimal('z_bbpb', 6, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('sp_periksa', fn (Blueprint $table) => $table->dropColumn(['z_bbu', 'z_tbu', 'z_bbpb']));
    }
};
