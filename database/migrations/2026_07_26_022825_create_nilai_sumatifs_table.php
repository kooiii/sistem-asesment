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
    Schema::create('nilai_sumatifs', function (Blueprint $table) {
        $table->id();

        $table->foreignId('siswa_id')->constrained()->cascadeOnDelete();

        $table->enum('jenis', [
            'STS',
            'SAS'
        ]);

        $table->decimal('nilai',5,2);
        $table->foreignId('mapel_id')->constrained()->cascadeOnDelete();

        $table->foreignId('tahun_ajaran_id')
        ->constrained('tahun_ajarans')
        ->cascadeOnDelete();

        $table->unique([
        'siswa_id',
        'mapel_id',
        'tahun_ajaran_id',
        'jenis'
        ]);
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_sumatifs');
    }
};
