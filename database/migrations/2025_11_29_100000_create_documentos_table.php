<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     * 
     * Tabla de documentos adjuntos a cuentas de cobro con control de versiones,
     * categorías y metadatos.
     */
    public function up(): void
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            
            // Relación con cuenta de cobro
            $table->unsignedBigInteger('cuenta_cobro_id');
            $table->foreign('cuenta_cobro_id')
                  ->references('id')
                  ->on('cuentas_cobro')
                  ->onDelete('cascade');
            
            // Información del documento
            $table->string('nombre_original');  // Nombre original del archivo
            $table->string('nombre_almacenado'); // Nombre del archivo en storage
            $table->string('tipo_documento');    // factura, contrato, comprobante, otro
            $table->string('mime_type');        // application/pdf, image/png, etc.
            $table->integer('tamaño_bytes');    // Tamaño del archivo
            
            // Metadatos
            $table->text('descripcion')->nullable();
            $table->string('categoria')->nullable(); // soporte, contrato, comprobante_pago, anexo
            $table->string('etiquetas')->nullable(); // JSON array de etiquetas
            
            // Control de versiones
            $table->integer('version')->default(1);
            $table->unsignedBigInteger('documento_anterior_id')->nullable();
            $table->foreign('documento_anterior_id')
                  ->references('id')
                  ->on('documentos')
                  ->onDelete('set null');
            
            // Usuario que subió
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            
            // Rutas de almacenamiento
            $table->string('ruta_disco')->default('public'); // Disco de almacenamiento
            $table->string('ruta_archivo');    // Ruta completa del archivo
            $table->string('ruta_temporal')->nullable(); // Para archivos en proceso
            
            // Visibilidad y control de acceso
            $table->string('visibilidad')->default('private'); // private, internal, public
            $table->json('roles_acceso')->nullable(); // Array de roles que pueden ver
            
            // Auditoría
            $table->timestamp('fecha_subida')->useCurrent();
            $table->timestamp('fecha_ultima_descarga')->nullable();
            $table->integer('cantidad_descargas')->default(0);
            $table->boolean('escaneado_virus')->default(false); // Para seguridad
            $table->timestamp('archivado_at')->nullable();
            
            $table->timestamps();
            
            // Índices para búsquedas comunes
            $table->index('cuenta_cobro_id');
            $table->index('tipo_documento');
            $table->index('categoria');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
