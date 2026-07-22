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
    Schema::table('presensi_sikaps', function (Blueprint $table) {
        $table->decimal('nm',5,2)->nullable()->after('sikap');
        $table->decimal('n',5,2)->nullable()->after('nm');
    });
}

public function down(): void
{
    Schema::table('presensi_sikaps', function (Blueprint $table) {
        $table->dropColumn(['nm','n']);
    });
}
};