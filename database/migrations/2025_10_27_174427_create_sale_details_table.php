<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar la migración.
     */
    public function up(): void
    {
        Schema::create('sales_details', function (Blueprint $table) {
            $table->id();

            // Relación con la venta
            $table->foreignId('sale_id')
                  ->constrained('sales')
                  ->onDelete('cascade')
                  ->comment('ID de la venta a la que pertenece este detalle');

            // Relación con el producto
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade')
                  ->comment('ID del producto vendido');

            $table->integer('quantity')->comment('Cantidad vendida del producto');
            $table->decimal('unit_price', 12, 2)->comment('Precio unitario del producto');
            $table->decimal('subtotal', 14, 2)->comment('Subtotal = quantity * unit_price');

            $table->timestamps();
            $table->softDeletes(); // Eliminación lógica
        });
    }

    /**
     * Revertir la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_details');
    }
};
