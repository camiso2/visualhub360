<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();

            // Relación con la empresa principal
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');

            // Clave de sincronización local usada por el cliente Java
            $table->string('local_sync_key', 36)->unique(); // UUID generado al instalar el cliente

            // Información general de la sucursal
            $table->string('name');
            $table->string('code', 20)->unique(); // Código interno de la sucursal
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('department')->nullable();

            // Configuración
            $table->boolean('active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
