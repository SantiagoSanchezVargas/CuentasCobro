<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Catálogo PUC (Plan Único de Cuentas) Colombia
        Schema::create('puc_catalogo', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->string('nombre');
            $table->string('naturaleza', 20)->nullable(); // Débito, Crédito
            $table->string('clase', 50)->nullable(); // Activo, Pasivo, Patrimonio, Ingresos, Gastos, Costos
            $table->string('grupo', 100)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Códigos de país ISO con indicativos telefónicos
        Schema::create('paises', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_iso2', 2)->unique();
            $table->string('codigo_iso3', 3)->unique();
            $table->string('nombre');
            $table->string('nombre_en')->nullable();
            $table->string('indicativo', 10);
            $table->string('moneda', 3)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Responsabilidades fiscales DIAN
        Schema::create('responsabilidades_fiscales', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 10)->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Centro de costos
        Schema::create('centros_costo', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Productos/Servicios catálogo
        Schema::create('productos_servicios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('tipo', 20)->default('servicio'); // producto, servicio
            $table->string('puc_codigo', 20)->nullable();
            $table->decimal('precio_unitario', 15, 2)->default(0);
            $table->decimal('iva_porcentaje', 5, 2)->default(19);
            $table->string('unidad_medida', 20)->default('UND');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('puc_codigo')->references('codigo')->on('puc_catalogo')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos_servicios');
        Schema::dropIfExists('centros_costo');
        Schema::dropIfExists('responsabilidades_fiscales');
        Schema::dropIfExists('paises');
        Schema::dropIfExists('puc_catalogo');
    }
};
