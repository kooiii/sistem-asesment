<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('nilai_formatifs', function (Blueprint $table) {

        $table->unique([
            'tp_id',
            'siswa_id',
            'teknik'
        ]);

        });
    }

    public function down()
    {
        Schema::table('nilai_formatifs', function (Blueprint $table) {

        $table->dropUnique([
            'tp_id',
            'siswa_id',
            'teknik'
        ]);

        });
    }
};