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
        Schema::table('ph_keterampilans', function (Blueprint $table) {
            $table->decimal('r2',5,2)->nullable();
            $table->decimal('n',5,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ph_keterampilans', function (Blueprint $table) {
            //
        });
    }
};
