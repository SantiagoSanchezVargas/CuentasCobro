<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Agrega campos según los requisitos legales de una cuenta de cobro en Colombia:
     * - Identificación completa del acreedor (quien cobra)
     * - Identificación completa del deudor (quien debe pagar)
     * - Concepto detallado del cobro
     * - Fechas importantes (servicio prestado, vencimiento, etc.)
     * - Información de firmas y validación
     * - Campos para proceso monitorio y cobro judicial
     */
    public function up(): void
    {
        Schema::table('cuentas_cobro', function (Blueprint $table) {
            // === IDENTIFICACIÓN DEL ACREEDOR (quien cobra) ===
            $table->string('nombre_acreedor')->nullable()->after('nombre_beneficiario');
            $table->enum('tipo_documento_acreedor', ['CC', 'CE', 'NIT', 'Pasaporte', 'TI'])->nullable()->after('nombre_acreedor');
            $table->string('numero_documento_acreedor')->nullable()->after('tipo_documento_acreedor');
            $table->string('ciudad_expedicion_acreedor')->nullable()->after('numero_documento_acreedor');
            $table->string('direccion_acreedor')->nullable()->after('ciudad_expedicion_acreedor');
            $table->string('telefono_acreedor')->nullable()->after('direccion_acreedor');
            $table->string('email_acreedor')->nullable()->after('telefono_acreedor');
            
            // === IDENTIFICACIÓN DEL DEUDOR (quien debe pagar) ===
            $table->string('nombre_deudor')->nullable()->after('email_acreedor');
            $table->enum('tipo_documento_deudor', ['CC', 'CE', 'NIT', 'Pasaporte', 'TI'])->nullable()->after('nombre_deudor');
            $table->string('numero_documento_deudor')->nullable()->after('tipo_documento_deudor');
            $table->string('ciudad_expedicion_deudor')->nullable()->after('numero_documento_deudor');
            $table->string('direccion_deudor')->nullable()->after('ciudad_expedicion_deudor');
            $table->string('telefono_deudor')->nullable()->after('direccion_deudor');
            $table->string('email_deudor')->nullable()->after('telefono_deudor');
            
            // === CONCEPTO DEL COBRO ===
            $table->longText('concepto_cobro')->nullable()->after('descripcion');
            $table->longText('descripcion_servicio')->nullable()->after('concepto_cobro');
            $table->date('fecha_prestacion_servicio')->nullable()->after('descripcion_servicio');
            $table->date('fecha_inicio_servicio')->nullable()->after('fecha_prestacion_servicio');
            $table->date('fecha_fin_servicio')->nullable()->after('fecha_inicio_servicio');
            $table->string('lugar_prestacion_servicio')->nullable()->after('fecha_fin_servicio');
            
            // === INFORMACIÓN CONTRACTUAL ===
            $table->string('numero_contrato_referencia')->nullable()->after('lugar_prestacion_servicio');
            $table->date('fecha_contrato')->nullable()->after('numero_contrato_referencia');
            $table->enum('tipo_contrato', [
                'Prestación de servicios',
                'Compraventa',
                'Consultoría',
                'Honorarios profesionales',
                'Arrendamiento',
                'Obra',
                'Otro'
            ])->nullable()->after('fecha_contrato');
            $table->string('objeto_contrato', 500)->nullable()->after('tipo_contrato');
            
            // === FIRMAS Y VALIDACIÓN ===
            $table->boolean('firmado_acreedor')->default(false)->after('objeto_contrato');
            $table->timestamp('fecha_firma_acreedor')->nullable()->after('firmado_acreedor');
            $table->string('firma_acreedor_url')->nullable()->after('fecha_firma_acreedor');
            $table->string('firma_acreedor_ip')->nullable()->after('firma_acreedor_url');
            
            $table->boolean('firmado_deudor')->default(false)->after('firma_acreedor_ip');
            $table->timestamp('fecha_firma_deudor')->nullable()->after('firmado_deudor');
            $table->string('firma_deudor_url')->nullable()->after('fecha_firma_deudor');
            $table->string('firma_deudor_ip')->nullable()->after('firma_deudor_url');
            
            // === DOCUMENTO SOPORTE (para efectos fiscales) ===
            $table->string('numero_documento_soporte')->nullable()->after('firma_deudor_ip');
            $table->date('fecha_documento_soporte')->nullable()->after('numero_documento_soporte');
            $table->string('documento_soporte_url')->nullable()->after('fecha_documento_soporte');
            $table->boolean('requiere_validacion_previa')->default(false)->after('documento_soporte_url');
            $table->timestamp('fecha_validacion_dian')->nullable()->after('requiere_validacion_previa');
            
            // === INFORMACIÓN LEGAL Y COBRO JUDICIAL ===
            $table->enum('estado_cobro_judicial', [
                'Sin proceso',
                'Proceso monitorio',
                'Proceso ejecutivo',
                'Conciliación',
                'Acuerdo de pago',
                'Cobrado'
            ])->default('Sin proceso')->after('fecha_validacion_dian');
            $table->string('numero_proceso_judicial')->nullable()->after('estado_cobro_judicial');
            $table->date('fecha_inicio_proceso')->nullable()->after('numero_proceso_judicial');
            $table->string('juzgado')->nullable()->after('fecha_inicio_proceso');
            $table->string('radicado_judicial')->nullable()->after('juzgado');
            
            // === MÉRITO EJECUTIVO Y RECONOCIMIENTO ===
            $table->boolean('tiene_merito_ejecutivo')->default(false)->after('radicado_judicial');
            $table->boolean('deuda_reconocida_deudor')->default(false)->after('tiene_merito_ejecutivo');
            $table->text('evidencias_obligacion')->nullable()->after('deuda_reconocida_deudor');
            $table->text('testigos')->nullable()->after('evidencias_obligacion');
            
            // === CIUDAD Y FECHA DE EXPEDICIÓN ===
            $table->string('ciudad_expedicion_cuenta')->nullable()->after('departamento');
            $table->timestamp('fecha_hora_emision')->nullable()->after('fecha_emision');
            
            // === PLAZOS Y FECHAS IMPORTANTES ===
            $table->integer('dias_plazo_pago')->nullable()->after('plazo_pago');
            $table->date('fecha_vencimiento_real')->nullable()->after('fecha_maxima_pago');
            $table->integer('dias_gracia')->default(0)->after('fecha_vencimiento_real');
            $table->date('fecha_vencimiento_con_gracia')->nullable()->after('dias_gracia');
            
            // === INFORMACIÓN ADICIONAL ===
            $table->text('clausulas_especiales')->nullable()->after('fecha_vencimiento_con_gracia');
            $table->text('condiciones_pago')->nullable()->after('clausulas_especiales');
            $table->string('forma_pago_acordada')->nullable()->after('condiciones_pago'); // Efectivo, transferencia, cheque
            $table->text('penalidades_retraso')->nullable()->after('forma_pago_acordada');
            $table->decimal('interes_mora_porcentaje', 5, 2)->default(0)->after('penalidades_retraso');
            $table->boolean('cobra_intereses_mora')->default(false)->after('interes_mora_porcentaje');
            
            // === CONSECUTIVO Y SERIE ===
            $table->string('prefijo_cuenta')->nullable()->after('numero');
            $table->string('serie_cuenta')->nullable()->after('prefijo_cuenta');
            $table->integer('consecutivo_cuenta')->nullable()->after('serie_cuenta');
            
            // === OBSERVACIONES LEGALES ===
            $table->text('observaciones_legales')->nullable()->after('observaciones_internas');
            $table->text('notas_cobro')->nullable()->after('observaciones_legales');
            
            // === ÍNDICES PARA BÚSQUEDAS ===
            $table->index('numero_documento_acreedor', 'idx_doc_acreedor');
            $table->index('numero_documento_deudor', 'idx_doc_deudor');
            $table->index('estado_cobro_judicial', 'idx_estado_judicial');
            $table->index(['firmado_acreedor', 'firmado_deudor'], 'idx_firmas');
            $table->index('fecha_prestacion_servicio', 'idx_fecha_servicio');
            $table->index('numero_proceso_judicial', 'idx_proceso_judicial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuentas_cobro', function (Blueprint $table) {
            // Eliminar índices primero
            $table->dropIndex('idx_doc_acreedor');
            $table->dropIndex('idx_doc_deudor');
            $table->dropIndex('idx_estado_judicial');
            $table->dropIndex('idx_firmas');
            $table->dropIndex('idx_fecha_servicio');
            $table->dropIndex('idx_proceso_judicial');
            
            // Eliminar columnas
            $table->dropColumn([
                // Acreedor
                'nombre_acreedor', 'tipo_documento_acreedor', 'numero_documento_acreedor',
                'ciudad_expedicion_acreedor', 'direccion_acreedor', 'telefono_acreedor', 'email_acreedor',
                // Deudor
                'nombre_deudor', 'tipo_documento_deudor', 'numero_documento_deudor',
                'ciudad_expedicion_deudor', 'direccion_deudor', 'telefono_deudor', 'email_deudor',
                // Concepto
                'concepto_cobro', 'descripcion_servicio', 'fecha_prestacion_servicio',
                'fecha_inicio_servicio', 'fecha_fin_servicio', 'lugar_prestacion_servicio',
                // Contractual
                'numero_contrato_referencia', 'fecha_contrato', 'tipo_contrato', 'objeto_contrato',
                // Firmas
                'firmado_acreedor', 'fecha_firma_acreedor', 'firma_acreedor_url', 'firma_acreedor_ip',
                'firmado_deudor', 'fecha_firma_deudor', 'firma_deudor_url', 'firma_deudor_ip',
                // Documento soporte
                'numero_documento_soporte', 'fecha_documento_soporte', 'documento_soporte_url',
                'requiere_validacion_previa', 'fecha_validacion_dian',
                // Legal
                'estado_cobro_judicial', 'numero_proceso_judicial', 'fecha_inicio_proceso',
                'juzgado', 'radicado_judicial',
                // Mérito ejecutivo
                'tiene_merito_ejecutivo', 'deuda_reconocida_deudor', 'evidencias_obligacion', 'testigos',
                // Expedición
                'ciudad_expedicion_cuenta', 'fecha_hora_emision',
                // Plazos
                'dias_plazo_pago', 'fecha_vencimiento_real', 'dias_gracia', 'fecha_vencimiento_con_gracia',
                // Adicional
                'clausulas_especiales', 'condiciones_pago', 'forma_pago_acordada',
                'penalidades_retraso', 'interes_mora_porcentaje', 'cobra_intereses_mora',
                // Consecutivo
                'prefijo_cuenta', 'serie_cuenta', 'consecutivo_cuenta',
                // Observaciones
                'observaciones_legales', 'notas_cobro'
            ]);
        });
    }
};
