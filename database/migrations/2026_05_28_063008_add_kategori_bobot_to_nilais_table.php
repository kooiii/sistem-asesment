<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            if (!Schema::hasColumn('nilais', 'kategori'))
        {

            $table->string('kategori')->nullable();
        }
        if (!Schema::hasColumn('nilais', 'bobot')) {
             $table->integer('bobot')->nullable();
        }


        });
    }

    public function down(): void
    {
        Schema::table('nilais', function (Blueprint $table) {

           if (Schema::hascolumn('nilais', 'kategori')) {
            $table->dropColumn('kategori');
           }
           if (Schema::hasColumn('nilais', 'bobot')) {
            $table->dropColumn('bobot');
           }

        });
    }
};