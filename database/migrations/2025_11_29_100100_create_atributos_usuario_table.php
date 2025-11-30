<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     * 
     * Tabla de atributos de usuario para almacenar información adicional
     * como departamento, puesto, teléfono, extensión, etc.
     */
    public function up(): void
    {
        Schema::create('atributos_usuario', function (Blueprint $table) {
            $table->id();
            
            // Relación con usuario
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            
            // Información personal
            $table->string('nombre_completo')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('telefono')->nullable();
            $table->string('extension')->nullable();
            $table->string('celular_personal')->nullable();
            $table->string('email_alterno')->nullable();
            
            // Información laboral
            $table->string('departamento')->nullable();     // Ej: Tesorería, Contratación
            $table->string('puesto')->nullable();           // Ej: Jefe, Asistente, Coordinador
            $table->string('codigo_empleado')->nullable();
            $table->string('nivel_jerarquico')->nullable(); // 1-5 para reportes
            
            // Información de firma digital
            $table->text('firma_electronica')->nullable();  // Imagen base64
            $table->string('numero_firma_digital')->nullable();
            $table->date('fecha_vencimiento_firma')->nullable();
            
            // Preferencias
            $table->boolean('notificaciones_email')->default(true);
            $table->boolean('notificaciones_sms')->default(false);
            $table->string('idioma_preferido')->default('es');
            $table->string('zona_horaria')->nullable();
            
            // Información de delegación
            $table->unsignedBigInteger('user_id_delegado')->nullable();
            $table->foreign('user_id_delegado')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
            $table->dateTime('fecha_inicio_delegacion')->nullable();
            $table->dateTime('fecha_fin_delegacion')->nullable();
            $table->boolean('puede_delegar')->default(false);
            
            // Información de desempeño y límites
            $table->integer('limite_aprobacion_valor')->nullable(); // En pesos
            $table->integer('limite_cuentas_simultaneas')->nullable();
            $table->integer('dias_para_aprobar')->default(5);
            
            // Auditoría
            $table->string('ultimo_ip_login')->nullable();
            $table->timestamp('ultimo_login_at')->nullable();
            $table->integer('intentos_fallidos_login')->default(0);
            
            $table->timestamps();
            
            // Índices
            $table->index('user_id');
            $table->index('departamento');
            $table->index('puesto');
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('atributos_usuario');
    }
};
