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
        Schema::table('terceros', function (Blueprint $table) {
            if (!Schema::hasColumn('terceros', 'pais')) {
                $table->string('pais')->default('Colombia')->after('direccion');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('terceros', function (Blueprint $table) {
            if (Schema::hasColumn('terceros', 'pais')) {
                $table->dropColumn('pais');
            }
        });
    }
};
