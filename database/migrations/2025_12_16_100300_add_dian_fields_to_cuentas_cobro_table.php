<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cuentas_cobro', function (Blueprint $table) {
            if (!Schema::hasColumn('cuentas_cobro', 'cufe')) {
                $table->string('cufe')->nullable()->unique()->after('numero');
            }

            if (!Schema::hasColumn('cuentas_cobro', 'estado_dian')) {
                $table->string('estado_dian')->default('sin_envio')->after('cufe')->index();
            }

            if (!Schema::hasColumn('cuentas_cobro', 'fecha_envio_dian')) {
                $table->timestamp('fecha_envio_dian')->nullable()->after('estado_dian');
            }

            if (!Schema::hasColumn('cuentas_cobro', 'mensaje_dian')) {
                $table->text('mensaje_dian')->nullable()->after('fecha_envio_dian');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cuentas_cobro', function (Blueprint $table) {
            if (Schema::hasColumn('cuentas_cobro', 'mensaje_dian')) {
                $table->dropColumn('mensaje_dian');
            }

            if (Schema::hasColumn('cuentas_cobro', 'fecha_envio_dian')) {
                $table->dropColumn('fecha_envio_dian');
            }

            if (Schema::hasColumn('cuentas_cobro', 'estado_dian')) {
                $table->dropColumn('estado_dian');
            }

            if (Schema::hasColumn('cuentas_cobro', 'cufe')) {
                $table->dropColumn('cufe');
            }
        });
    }
};
