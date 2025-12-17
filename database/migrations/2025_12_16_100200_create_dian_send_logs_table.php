<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dian_send_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuenta_cobro_id')->nullable()->constrained('cuentas_cobro')->nullOnDelete();
            $table->string('document_type')->nullable();
            $table->string('document_number')->nullable();
            $table->string('status')->default('pending');
            $table->json('response_payload')->nullable();
            $table->unsignedInteger('attempts')->default(0);
            $table->text('last_error')->nullable();
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dian_send_logs');
    }
};
