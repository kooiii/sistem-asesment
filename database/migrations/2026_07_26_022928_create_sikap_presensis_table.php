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
    Schema::create('sikap_presensis', function (Blueprint $table) {
        $table->id();

        $table->foreignId('siswa_id')->constrained()->cascadeOnDelete();

        $table->decimal('sikap',5,2);
        $table->decimal('presensi',5,2);
        $table->foreignId('tahun_ajaran_id')
        ->constrained()
        ->cascadeOnDelete();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sikap_presensis');
    }
};
