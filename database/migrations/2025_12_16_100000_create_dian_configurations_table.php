<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dian_configurations', function (Blueprint $table) {
            $table->id();
            $table->enum('mode', ['set', 'production'])->default('set');
            $table->string('api_url')->nullable();
            $table->string('token')->nullable();
            $table->string('email_contact')->nullable();
            $table->string('certificate_path')->nullable();
            $table->text('certificate_pass')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dian_configurations');
    }
};
