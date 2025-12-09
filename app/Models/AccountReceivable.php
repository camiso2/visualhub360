<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\CompanyScope;
use App\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Casts\Attribute; // Importación necesaria

class AccountReceivable extends Model
{
    // Usamos SoftDeletes y Factories para desarrollo
    use HasFactory, SoftDeletes;

    protected $table = 'accounts_receivables';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'company_id',
        'branch_id',
        'sale_id',
        'payment_provider_id',
        'client_id',
        'amount',
        'paid_amount', // Monto que la compañía ha pagado/cubierto
        'status',      // pending, billed, paid, canceled
        'due_date',    // Fecha límite para el cobro/pago
        'paid_date',    // Fecha límite para el cobro/pago
        'description',    // Fecha límite para el cobro/pago
    ];

    // Los campos de fecha deben ser mutados
    protected $casts = [
        'due_date' => 'date',
    ];


    // 🔒 GLOBAL SCOPES DE SEGURIDAD
    // Estos scopes aseguran que solo se puedan consultar las cuentas
    // que pertenecen a la compañía y sucursal del usuario autenticado.
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope());
        static::addGlobalScope(new BranchScope());
    }

    // --- RELACIONES ---

    /**
     * Obtiene la venta que originó esta cuenta por cobrar.
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Obtiene el proveedor de pago al que se le debe cobrar (Ej: Addi, Sistecrédito).
     */
    public function paymentProvider()
    {
        return $this->belongsTo(PaymentProvider::class);
    }

    /**
     * Obtiene el cliente asociado a la venta.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Estos campos se añadirán automáticamente a la respuesta JSON.
    protected $appends = [
        'commission_percentage',
        'days_elapsed'
    ];

    // --- ACCESSORS (CAMPOS CALCULADOS) ---

    /**
     * Calcula el porcentaje de comisión cobrado por el proveedor.
     */
    protected function commissionPercentage(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // Solo calcula si la cuenta ha sido pagada (liquidada)
                if ($attributes['status'] !== 'paid' || $attributes['amount'] == 0) {
                    return null;
                }

                $amountDue = (float) $attributes['amount'];
                $paidAmount = (float) $attributes['paid_amount'];
                $commissionAmount = $amountDue - $paidAmount;

                // Devuelve el porcentaje formateado
                $percentage = ($commissionAmount / $amountDue) * 100;
                return round($percentage, 2);
            },
        );
    }

    /**
     * Calcula los días transcurridos desde la fecha de venta hasta la liquidación.
     */
    protected function daysElapsed(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // Solo calcula si la cuenta ha sido pagada
                if ($attributes['status'] !== 'paid') {
                    return null;
                }

                // Carga la relación de venta para obtener la fecha de creación.
                // Usamos el modelo Sale directamente si no hay relación cargada.
                $sale = $this->sale()->first();

                if (!$sale || !$sale->sale_date) {
                     return null;
                }

                // El campo updated_at de AccountReceivable será la fecha de pago
                $paidDate = $this->updated_at;

                // El campo sale_date del modelo Sale debe estar casteado como fecha/datetime
                $saleDate = $sale->sale_date;

                return $saleDate->diffInDays($paidDate);
            },
        );
    }
}
