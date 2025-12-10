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
        Schema::create('terceros', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_persona')->default('natural'); // natural, juridica
            $table->string('tipo_identificacion'); // CC, NIT, CE, PA
            $table->string('identificacion')->unique();
            $table->string('dv')->nullable(); // Digito de verificacion
            $table->string('nombre_completo')->nullable(); // Para persona natural
            $table->string('razon_social')->nullable(); // Para persona juridica
            $table->string('nombre_comercial')->nullable();
            $table->string('direccion')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('departamento')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->json('responsabilidad_fiscal')->nullable(); // Array of responsibilities
            $table->boolean('es_cliente')->default(false);
            $table->boolean('es_proveedor')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terceros');
    }
};
