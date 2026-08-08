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
        Schema::create('tujuan_pembelajarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained()->cascadeOnDelete();
            $table->foreignId('mapel_id')->constrained()->cascadeOnDelete();
            $table->integer('nomor_tp');
            $table->string('judul_tp');

            $table->foreignId('tahun_ajaran_id')
            ->constrained()
            ->cascadeOnDelete();

            $table->timestamps();
           });
        }

    public function down(): void
    {
        Schema::dropIfExists('tujuan_pembelajarans');
    }
   
};