<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     * 
     * Agregar campos a la tabla cuentas_cobro para mejorar funcionalidad contable:
     * descuentos, impuestos adicionales, campos de pago anticipado, retenciones mejoradas.
     */
    public function up(): void
    {
        Schema::table('cuentas_cobro', function (Blueprint $table) {
            // Campos de cálculo detallado
            $table->decimal('subtotal', 15, 2)->default(0)->after('valor_total');
            $table->decimal('descuento_valor', 15, 2)->default(0)->after('subtotal');
            $table->decimal('descuento_porcentaje', 5, 2)->default(0)->after('descuento_valor');
            
            // IVA y otros impuestos
            $table->decimal('iva_porcentaje', 5, 2)->default(19)->after('descuento_porcentaje');
            $table->decimal('iva_valor', 15, 2)->default(0)->after('iva_porcentaje');
            
            // Retenciones detalladas (mejoradas)
            $table->decimal('retencion_fuente_porcentaje', 5, 2)->default(0)->after('iva_valor');
            $table->decimal('retencion_fuente_valor', 15, 2)->default(0)->after('retencion_fuente_porcentaje');
            $table->decimal('retencion_ica_porcentaje', 5, 2)->default(0)->after('retencion_fuente_valor');
            $table->decimal('retencion_ica_valor', 15, 2)->default(0)->after('retencion_ica_porcentaje');
            $table->decimal('retencion_iva_porcentaje', 5, 2)->default(0)->after('retencion_ica_valor');
            $table->decimal('retencion_iva_valor', 15, 2)->default(0)->after('retencion_iva_porcentaje');
            $table->decimal('otras_retenciones_valor', 15, 2)->default(0)->after('retencion_iva_valor');
            
            // Pago anticipado
            $table->boolean('tiene_anticipo')->default(false)->after('otras_retenciones_valor');
            $table->decimal('valor_anticipo', 15, 2)->default(0)->after('tiene_anticipo');
            $table->decimal('valor_pendiente_pago', 15, 2)->default(0)->after('valor_anticipo');
            $table->string('referencia_anticipo')->nullable()->after('valor_pendiente_pago');
            $table->date('fecha_pago_anticipado')->nullable()->after('referencia_anticipo');
            
            // Información bancaria ampliada
            $table->string('tipo_cuenta_beneficiario')->nullable()->after('fecha_pago_anticipado'); // ahorros, corriente
            $table->string('numero_cuenta_beneficiario')->nullable()->after('tipo_cuenta_beneficiario');
            $table->string('banco_beneficiario')->nullable()->after('numero_cuenta_beneficiario');
            $table->string('cuenta_corriente_usuario')->nullable()->after('banco_beneficiario');
            
            // Información fiscal
            $table->string('nit_beneficiario')->nullable()->after('cuenta_corriente_usuario');
            $table->string('rut_url')->nullable()->after('nit_beneficiario');
            $table->boolean('responsable_iva')->default(false)->after('rut_url');
            $table->boolean('gran_contribuyente')->default(false)->after('responsable_iva');
            
            // Campos de control
            $table->string('numero_orden_compra')->nullable()->after('gran_contribuyente');
            $table->string('numero_cdp')->nullable()->after('numero_orden_compra');
            $table->string('numero_rgp')->nullable()->after('numero_cdp');
            $table->date('fecha_vencimiento_factura')->nullable()->after('numero_rgp');
            
            // Observaciones y justificación
            $table->longText('observaciones_internas')->nullable()->after('fecha_vencimiento_factura');
            $table->longText('justificacion_rechazo')->nullable()->after('observaciones_internas');
            $table->longText('justificacion_devolucion')->nullable()->after('justificacion_rechazo');
            
            // Campos de auditoría
            $table->timestamp('fecha_ultima_modificacion')->nullable()->after('justificacion_devolucion');
            $table->unsignedBigInteger('modificado_por')->nullable()->after('fecha_ultima_modificacion');
            $table->foreign('modificado_por')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::table('cuentas_cobro', function (Blueprint $table) {
            // Eliminar campos según su orden inverso
            if (Schema::hasColumn('cuentas_cobro', 'subtotal')) {
                $table->dropColumn([
                    'subtotal', 'descuento_valor', 'descuento_porcentaje',
                    'iva_porcentaje', 'iva_valor',
                    'retencion_fuente_porcentaje', 'retencion_fuente_valor',
                    'retencion_ica_porcentaje', 'retencion_ica_valor',
                    'retencion_iva_porcentaje', 'retencion_iva_valor',
                    'otras_retenciones_valor',
                    'tiene_anticipo', 'valor_anticipo', 'valor_pendiente_pago',
                    'referencia_anticipo', 'fecha_pago_anticipado',
                    'tipo_cuenta_beneficiario', 'numero_cuenta_beneficiario',
                    'banco_beneficiario', 'cuenta_corriente_usuario',
                    'nit_beneficiario', 'rut_url', 'responsable_iva',
                    'gran_contribuyente',
                    'numero_orden_compra', 'numero_cdp', 'numero_rgp',
                    'fecha_vencimiento_factura',
                    'observaciones_internas', 'justificacion_rechazo',
                    'justificacion_devolucion',
                    'fecha_ultima_modificacion', 'modificado_por'
                ]);
            }
            
            // Eliminar foreign key
            if (Schema::hasColumn('cuentas_cobro', 'modificado_por')) {
                $table->dropForeign(['modificado_por']);
            }
        });
    }
};
