<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accounts_receivables', function (Blueprint $table) {
            // Agrega la columna 'paid_date' de tipo timestamp, permitiendo nulos.
            $table->timestamp('paid_date')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('accounts_receivables', function (Blueprint $table) {
            // Define cómo revertir la migración (eliminar la columna)
            $table->dropColumn('paid_date');
        });
    }
};
