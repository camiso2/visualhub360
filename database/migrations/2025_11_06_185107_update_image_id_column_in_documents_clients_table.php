<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        // 1️⃣ Eliminar la foreign key manualmente (por nombre exacto)
        DB::statement('ALTER TABLE `documents_clients` DROP FOREIGN KEY `documents_clients_image_id_foreign`;');

        // 2️⃣ Cambiar el tipo de columna a JSON
        Schema::table('documents_clients', function (Blueprint $table) {
            $table->json('image_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('documents_clients', function (Blueprint $table) {
            $table->unsignedBigInteger('image_id')->nullable()->change();

            $table->foreign('image_id')
                ->references('id')
                ->on('image_documents_clients')
                ->onDelete('cascade');
        });
    }
};
