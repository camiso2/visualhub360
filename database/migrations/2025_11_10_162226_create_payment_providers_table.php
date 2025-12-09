<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        Schema::create('payment_providers', function (Blueprint $table) {
            $table->id();

            // CLAVES DE AISLAMIENTO
            // 1. Relación con la empresa
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            // 2. Relación con la sucursal (Asumo que esta relación también es necesaria)
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();

            // DATOS DEL PROVEEDOR
            $table->string('name')->nullable();
            // Haremos el 'name' único por la combinación (company_id, branch_id)
            $table->string('code', 20)->nullable(); // Código corto (ej: 'BN', 'VS')

            $table->boolean('is_active')->default(true);

            // ÍNDICE ÚNICO COMPUESTO
            // Esto asegura que el nombre y el código solo sean únicos dentro de una misma sucursal/empresa.
            $table->unique(['branch_id', 'name']);
            $table->unique(['branch_id', 'code']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_providers');
    }
};
