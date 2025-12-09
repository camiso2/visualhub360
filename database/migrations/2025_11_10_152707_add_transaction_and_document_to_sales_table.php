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
        Schema::table('sales', function (Blueprint $table) {

            // 1. Clave foránea para el documento (se relaciona con documents_clients)
            $table->foreignId('document_id')
                  ->nullable() // Asumo que no todas las ventas requieren un documento asociado inmediatamente
                  ->after('client_id')
                  ->constrained('documents_clients')
                  ->cascadeOnDelete();

            // 2. Número de la Transacción (campo simple de texto)
            $table->string('number_transactions')
                  ->nullable()
                  ->after('document_id');

            // NOTA: Si necesitas 'payment_id' más adelante, lo puedes agregar en otra migración.
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // Revertir en orden inverso:
            $table->dropColumn('number_transactions');
            $table->dropConstrainedForeignId('document_id');
        });
    }
};
