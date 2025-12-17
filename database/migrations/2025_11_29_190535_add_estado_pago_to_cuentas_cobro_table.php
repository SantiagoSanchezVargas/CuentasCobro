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
        Schema::table('cuentas_cobro', function (Blueprint $table) {
            $table->enum('estado_pago', ['pending', 'approved', 'rejected', 'paid'])
                  ->default('pending')
                  ->after('estado_aprobacion');
            // Registro de pago y observaciones
            if (!Schema::hasColumn('cuentas_cobro', 'pagado_por')) {
                $table->unsignedBigInteger('pagado_por')->nullable()->after('fecha_pago');
                $table->foreign('pagado_por')->references('id')->on('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('cuentas_cobro', 'observaciones')) {
                $table->longText('observaciones')->nullable()->after('pagado_por');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuentas_cobro', function (Blueprint $table) {
            // Al revertir, remover columnas añadidas
            if (Schema::hasColumn('cuentas_cobro', 'observaciones')) {
                $table->dropColumn('observaciones');
            }
            if (Schema::hasColumn('cuentas_cobro', 'pagado_por')) {
                // Intentar eliminar la foreign key si existe
                try {
                    $table->dropForeign(['pagado_por']);
                } catch (\Exception $e) {
                    // Ignorar si no existe
                }
                $table->dropColumn('pagado_por');
            }
            if (Schema::hasColumn('cuentas_cobro', 'estado_pago')) {
                $table->dropColumn('estado_pago');
            }
        });
    }
};
