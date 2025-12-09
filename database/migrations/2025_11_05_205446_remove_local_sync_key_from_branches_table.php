<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            // Elimina la columna si existe
            if (Schema::hasColumn('branches', 'local_sync_key')) {
                $table->dropColumn('local_sync_key');
            }
        });
    }

    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            // Vuelve a crear la columna si se revierte la migración
            if (!Schema::hasColumn('branches', 'local_sync_key')) {
                $table->string('local_sync_key')->default('')->after('active');
            }
        });
    }
};
