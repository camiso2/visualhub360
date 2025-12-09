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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            // Código único asignado por VisionHub360 (identificador global de la empresa)
            $table->string('vh_code', 20)->unique();

            // Información básica
            $table->string('name'); // Nombre comercial
            $table->string('legal_name')->nullable(); // Razón social
            $table->string('document_type', 10)->default('NIT');
            $table->string('document_number', 30)->unique(); // NIT o documento fiscal
            $table->string('dv', 5)->nullable(); // Dígito de verificación

            // Información de contacto
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();

            // Dirección
            $table->string('address')->nullable();
            $table->string('neighborhood')->nullable(); // Barrio o sector
            $table->string('city')->nullable();
            $table->string('department')->nullable();
            $table->string('country', 100)->default('Colombia');

            // Información tributaria
            $table->string('tax_regime')->nullable(); // Régimen común o simplificado
            $table->string('economic_activity_code', 10)->nullable(); // Código CIIU
            $table->string('billing_resolution')->nullable(); // Resolución de facturación DIAN
            $table->date('billing_resolution_date')->nullable();

            // Configuración y estado
            $table->boolean('is_verified')->default(false); // Validada por VisionHub360
            $table->boolean('active')->default(true);
            $table->string('logo_path')->nullable(); // Logo corporativo
            $table->string('color_theme')->nullable(); // Tema de color del sistema

            // Auditoría
            $table->timestamp('verified_at')->nullable();
            $table->softDeletes(); // Eliminación lógica
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
