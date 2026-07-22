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
        Schema::create('pts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('siswa_id');
            $table->foreignId('mapel_id');

            $table->integer('nm')->nullable();
            $table->integer('nr')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pts');
    }
};
