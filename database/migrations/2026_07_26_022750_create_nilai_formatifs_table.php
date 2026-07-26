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
    Schema::create('nilai_formatifs', function (Blueprint $table) {
        $table->id();

        $table->foreignId('siswa_id')->constrained()->cascadeOnDelete();

        $table->foreignId('tp_id')
              ->constrained('tujuan_pembelajarans')
              ->cascadeOnDelete();

        $table->enum('teknik', [
            'Tugas',
            'Kuis',
            'Praktik',
            'Presentasi'
        ]);

        $table->decimal('nilai',5,2);

        $table->unique([
        'tp_id',
        'siswa_id',
        'teknik'
        ]);
        
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
        Schema::dropIfExists('nilai_formatifs');
    }
};
