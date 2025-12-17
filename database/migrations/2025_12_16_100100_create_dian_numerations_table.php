<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dian_numerations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dian_configuration_id')->nullable()->constrained('dian_configurations')->nullOnDelete();
            $table->string('prefix')->nullable();
            $table->unsignedBigInteger('start_number');
            $table->unsignedBigInteger('end_number');
            $table->unsignedBigInteger('current_number')->default(0);
            $table->timestamp('authorized_at')->nullable();
            $table->string('resolution_number')->nullable();
            $table->boolean('active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dian_numerations');
    }
};
