<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // Se coloca después de 'payment_method' o similar, y es nullable.
            // La tabla de destino se llama 'payment_providers'.
            $table->foreignId('payment_provider_id')
                  ->nullable()
                  ->after('number_transactions') // Colocado después del número de transacción
                  ->constrained('payment_providers')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropConstrainedForeignId('payment_provider_id');
        });
    }
};
