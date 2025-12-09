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
        Schema::table('sale_items', function (Blueprint $table) {
            // Columna para almacenar el método de pago (ej: 'Addi', 'efectivo', 'tarjeta')
            $table->string('payment_method')->after('line_total');

            // Columna para la FK al proveedor de pago (null si es efectivo o tarjeta genérica)
            // Asume que la tabla payment_providers ya existe.
            $table->foreignId('payment_provider_id')
                  ->nullable()
                  ->constrained('payment_providers')
                  ->onDelete('set null')
                  ->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_items', function (Blueprint $table) {
            // Es importante eliminar primero la clave foránea antes de eliminar la columna
            $table->dropForeign(['payment_provider_id']);
            $table->dropColumn(['payment_provider_id', 'payment_method']);
        });
    }
};
