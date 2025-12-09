<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            // Eliminar índice único antiguo
            $table->dropUnique('permissions_name_guard_name_unique');

            // Crear nuevo índice único considerando la empresa
            $table->unique(['name', 'guard_name', 'company_id'], 'permissions_name_guard_name_company_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropUnique('permissions_name_guard_name_company_id_unique');
            $table->unique(['name', 'guard_name'], 'permissions_name_guard_name_unique');
        });
    }
};

