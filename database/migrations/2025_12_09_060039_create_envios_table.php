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
        Schema::create('envios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuenta_cobro_id')->constrained('cuentas_cobro')->onDelete('cascade');
            $table->foreignId('usuario_envia_id')->constrained('users')->onDelete('cascade');
            $table->string('destinatario_email');
            $table->string('destinatario_nombre');
            $table->string('tipo_envio')->default('email'); // email, dian, etc
            $table->text('mensaje')->nullable();
            $table->timestamp('fecha_envio')->useCurrent();
            $table->boolean('enviado_exitosamente')->default(false);
            $table->text('respuesta_servidor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envios');
    }
};
