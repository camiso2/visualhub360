<?php

// database/migrations/..._create_accounts_receivables_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts_receivables', function (Blueprint $table) {
            $table->id();

            // Claves de la Compañía y Sucursal (para Global Scopes)
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');

            // Relación con la Venta
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');

            // Relación con el Proveedor de Pago (Addi, Sistecrédito)
            $table->foreignId('payment_provider_id')->constrained('payment_providers')->onDelete('restrict');

            // Información del Cliente
            $table->foreignId('client_id')->constrained('clients')->onDelete('restrict');

            // Detalle Monetario
            $table->decimal('amount', 15, 2); // Monto total de la venta a cobrar
            $table->decimal('paid_amount', 15, 2)->default(0.00); // Monto pagado por tu empresa al proveedor

            // Estado de la cuenta
            $table->enum('status', ['pending', 'billed', 'paid', 'canceled'])->default('pending');

            // Fechas de seguimiento
            $table->date('due_date')->nullable(); // Fecha límite de pago/cobro

            $table->softDeletes();
            $table->timestamps();

            // Índice de búsqueda rápida
            $table->index(['company_id', 'branch_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts_receivables');
    }
};
