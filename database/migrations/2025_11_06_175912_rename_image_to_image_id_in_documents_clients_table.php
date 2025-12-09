<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('documents_clients', function (Blueprint $table) {
            // Agregar columna image_id
            $table->unsignedBigInteger('image_id')->nullable()->after('description');

            // Crear llave foránea hacia image_documents_clients
            $table->foreign('image_id')
                  ->references('id')
                  ->on('image_documents_clients')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('documents_clients', function (Blueprint $table) {
            $table->dropForeign(['image_id']);
            $table->dropColumn('image_id');
        });
    }
};



