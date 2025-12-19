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
        Schema::table('consecutivos', function (Blueprint $table) {
            $table->unsignedBigInteger('dian_numeration_id')->nullable()->after('activo');
            $table->foreign('dian_numeration_id')->references('id')->on('dian_numerations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consecutivos', function (Blueprint $table) {
            $table->dropForeign(['dian_numeration_id']);
            $table->dropColumn('dian_numeration_id');
        });
    }
};
