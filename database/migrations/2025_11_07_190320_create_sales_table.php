<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            // Aislamiento
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();

            // Relaciones de Usuario y Cliente
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Vendedor/Asesor
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();

            // Documento e Historial
            $table->string('invoice_number')->unique()->nullable();
            $table->date('sale_date'); // Fecha de la venta

            // Totales (Usamos decimal para precisión en dinero)
            $table->decimal('total_amount', 10, 2)->default(0.00)->comment('Subtotal antes de impuestos y descuentos');
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('grand_total', 10, 2)->default(0.00)->comment('Total final');

            // Estado y Pago
            $table->string('status')->default('completed'); // e.g., completed, canceled, pending
            $table->string('payment_method')->nullable(); // e.g., cash, card, transfer

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
