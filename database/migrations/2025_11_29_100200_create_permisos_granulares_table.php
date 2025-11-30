<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     * 
     * Tabla de permisos granulares que permite control fino sobre qué acciones
     * pueden realizar los usuarios en diferentes etapas del flujo.
     */
    public function up(): void
    {
        Schema::create('permisos_granulares', function (Blueprint $table) {
            $table->id();
            
            // Relación con rol
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')
                  ->references('id')
                  ->on('roles')
                  ->onDelete('cascade');
            
            // Permisos por etapa de flujo
            $table->string('etapa_flujo')->nullable(); // supervisor, ordenador_gasto, etc. o null para todas
            $table->string('accion')->nullable();      // crear, leer, actualizar, eliminar, aprobar, rechazar, etc.
            
            // Permisos por estado
            $table->string('estado_requerido')->nullable(); // en_revision, aprobado, rechazado, etc.
            
            // Permisos granulares específicos
            $table->boolean('puede_crear')->default(false);
            $table->boolean('puede_leer')->default(false);
            $table->boolean('puede_editar')->default(false);
            $table->boolean('puede_eliminar')->default(false);
            $table->boolean('puede_aprobar')->default(false);
            $table->boolean('puede_rechazar')->default(false);
            $table->boolean('puede_devolver')->default(false);
            $table->boolean('puede_devolver_correccion')->default(false);
            $table->boolean('puede_comentar')->default(false);
            $table->boolean('puede_subir_documentos')->default(false);
            $table->boolean('puede_descargar_documentos')->default(false);
            $table->boolean('puede_registrar_pago')->default(false);
            $table->boolean('puede_enviar_cliente')->default(false);
            $table->boolean('puede_archivar')->default(false);
            $table->boolean('puede_ver_todas_cuentas')->default(false);
            $table->boolean('puede_ver_reportes')->default(false);
            $table->boolean('puede_gestionar_usuarios')->default(false);
            $table->boolean('puede_gestionar_contratos')->default(false);
            
            // Permisos de visualización con restricciones
            $table->json('campos_visibles')->nullable();      // Array de campos que puede ver
            $table->json('campos_editables')->nullable();     // Array de campos que puede editar
            $table->json('roles_visibles')->nullable();       // Puede ver cuentas de qué roles
            $table->json('departamentos_visibles')->nullable(); // Puede ver cuentas de qué departamentos
            
            // Condiciones adicionales
            $table->string('valor_minimo_aprobacion')->nullable(); // Monto mínimo para aprobar
            $table->string('valor_maximo_aprobacion')->nullable(); // Monto máximo para aprobar
            $table->boolean('requiere_segundo_aprobador')->default(false);
            $table->integer('dias_para_aprobar')->nullable();
            
            // Control y auditoría
            $table->boolean('activo')->default(true);
            $table->text('descripcion')->nullable();
            $table->timestamp('fecha_inicio_vigencia')->nullable();
            $table->timestamp('fecha_fin_vigencia')->nullable();
            
            $table->timestamps();
            
            // Índices
            $table->index('role_id');
            $table->index(['role_id', 'etapa_flujo']);
            $table->index('activo');
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('permisos_granulares');
    }
};
