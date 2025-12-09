<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();

            // Relaciones Clave
            $table->foreignId('sale_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inventory_id')->constrained()->cascadeOnDelete(); // FK al producto de inventario

            // Snapshot y Cantidad
            $table->string('sku'); // Copia del SKU para referencia histórica
            $table->integer('quantity')->comment('Unidades vendidas de este producto');
            $table->decimal('unit_price', 10, 2); // Precio al momento de la venta

            // Impuestos y Descuentos Históricos
            $table->decimal('tax_rate', 5, 2)->comment('Tasa de impuesto aplicada');
            $table->decimal('discount_applied', 10, 2)->default(0.00)->comment('Descuento total en esta línea');
            $table->decimal('line_total', 10, 2); // Total de la línea (incluye tax y discount)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
