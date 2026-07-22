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
        Schema::create('ph_pengetahuans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('siswa_id');
            $table->foreignId('mapel_id');

            $table->integer('tp1')->nullable();
            $table->integer('tp2')->nullable();
            $table->integer('tp3')->nullable();
            $table->integer('tp4')->nullable();
            $table->integer('tp5')->nullable();
            $table->integer('tp6')->nullable();
            $table->integer('tp7')->nullable();
            $table->integer('tp8')->nullable();
            $table->integer('tp9')->nullable();
            $table->integer('tp10')->nullable();
            $table->integer('tp11')->nullable();
            $table->integer('tp12')->nullable();

            $table->decimal('r2',5,2)->nullable();
            $table->decimal('n',5,2)->nullable();
            
            $table->timestamps();

            $table->foreign('siswa_id')
              ->references('id')
              ->on('siswas')
              ->onDelete('cascade');

            $table->foreign('mapel_id')
              ->references('id')
              ->on('mapels')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ph_pengetahuans');
    }
};
