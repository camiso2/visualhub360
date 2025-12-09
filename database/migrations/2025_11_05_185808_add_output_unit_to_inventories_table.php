<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta los cambios en la base de datos.
     */
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            // Agregamos el nuevo campo después de 'sale_price' para mantener el orden lógico
            $table->string('output_unit', 50)->nullable()->after('sale_price');
        });
    }

    /**
     * Revierte los cambios.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('output_unit');
        });
    }
};
