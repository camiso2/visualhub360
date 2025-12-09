<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\CompanyScope;
use App\Scopes\BranchScope;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Sale extends Model
{
    use HasApiTokens, HasFactory, HasRoles, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'user_id',
        'client_id',
        'number_transactions',
        'payment_provider_id',
        'document_id',
        'invoice_number',
        'sale_date',
        'total_amount',
        'tax_amount',
        'discount_amount',
        'grand_total',
        'status',
        'payment_method',
    ];

    /**
     * Obtiene el proveedor de pago asociado a la venta.
     */
    public function paymentProvider()
    {
        // Una venta pertenece a un proveedor de pago (o es nula si es en efectivo)
        return $this->belongsTo(PaymentProvider::class);
    }

    // Aplicar los Global Scopes
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope());
        static::addGlobalScope(new BranchScope());
    }

    // Relaciones Maestro-Detalle
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Otras Relaciones
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    // En App\Models\Sale.php
    protected $casts = [
        // ... otros casts
        'sale_date' => 'datetime',
    ];
}
