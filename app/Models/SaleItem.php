<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Importaciones de Modelos necesarios para las relaciones
use App\Models\Inventory;
use App\Models\Sale;
use App\Models\PaymentProvider;

class SaleItem extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     * Incluye los campos base y los campos de pago por ítem.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sale_id',
        'inventory_id',
        'sku',
        'quantity',
        'unit_price',
        'tax_rate',
        'discount_applied',
        'line_total',
        // Campos relacionados con el pago (para el nuevo flujo)
        'payment_method',
        'payment_provider_id',
    ];

    // --- RELACIONES ELOQUENT ---



    /**
     * Define la relación con el registro de venta maestro (Sale).
     * * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Define la relación con el producto vendido (Inventory).
     * * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    /**
     * Define la relación con el Proveedor de Pago (ej: Addi, Bancolombia, etc.).
     * Esta es la relación que faltaba y que resuelve el error en el controlador.
     * * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentProvider()
    {
        return $this->belongsTo(PaymentProvider::class, 'payment_provider_id');
    }
}
