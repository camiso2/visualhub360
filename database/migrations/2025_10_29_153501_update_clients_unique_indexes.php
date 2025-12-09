<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // Eliminar las restricciones únicas globales si existen
            $table->dropUnique(['email']); // elimina clients_email_unique
            $table->dropUnique(['document_number']); // elimina clients_document_number_unique si existe

            // Crear índices únicos compuestos por empresa
            $table->unique(['company_id', 'email'], 'clients_company_email_unique');
            $table->unique(['company_id', 'document_number'], 'clients_company_document_unique');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // Revertir los cambios si es necesario
            $table->dropUnique('clients_company_email_unique');
            $table->dropUnique('clients_company_document_unique');

            $table->unique('email');
            $table->unique('document_number');
        });
    }
};
