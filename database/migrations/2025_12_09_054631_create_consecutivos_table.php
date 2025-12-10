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
        Schema::create('consecutivos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_documento')->default('Cuenta de Cobro'); // Ej: Cuenta de Cobro, Documento Soporte
            $table->string('prefijo')->nullable(); // Ej: DS, CC
            $table->integer('numero_inicial');
            $table->integer('numero_final');
            $table->integer('numero_actual');
            $table->date('vigencia_inicio');
            $table->date('vigencia_fin');
            $table->string('resolucion')->nullable(); // Número de resolución DIAN si aplica
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consecutivos');
    }
};
