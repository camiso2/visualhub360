<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accounts_receivables', function (Blueprint $table) {
            // Se recomienda usar 'text' para descripciones largas.
            // La hacemos nullable, ya que no todas las cuentas tendrán una descripción.
            $table->text('description')->nullable()->after('client_id');
            // Puedes usar ->after('client_id') para especificar la posición.
        });
    }

    public function down(): void
    {
        Schema::table('accounts_receivables', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
