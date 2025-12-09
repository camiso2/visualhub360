<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('image_documents_clients', function (Blueprint $table) {
            if (!Schema::hasColumn('image_documents_clients', 'client_id')) {
                $table->unsignedBigInteger('client_id')->after('company_id')->nullable();

                // Relación con tabla clients (opcional)
                $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('image_documents_clients', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
    }
};
