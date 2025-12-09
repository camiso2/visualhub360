<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\CompanyScope;
use App\Scopes\BranchScope;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Inventory extends Model
{
    use HasApiTokens, HasFactory, HasRoles, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'sku',
        'name',
        'category',
        'description',
        'quantity',
        'output_unit',
        'min_stock',
        'purchase_price',
        'net_price',
        'sale_price',
        'tax_purchase',
        'tax_sale',
        'max_disscount',
        'number_invoice',
        'image',
        'image_invoice',
        'supplier_id',
        'active',
        'user_id'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope());

        // Aislamiento por SUCURSAL (branch_id), con excepción para Admin General
        static::addGlobalScope(new BranchScope());
    }

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
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }


    /**
     * Summary of scopeBySku
     * @param mixed $query
     * @param mixed $sku
     */
    public function scopeBySku($query, $sku)
    {
        return $query->where('sku', $sku);
    }

   /* public function paymentProvider()
    {
        return $this->belongsTo(PaymentProvider::class);
    }*/


}
