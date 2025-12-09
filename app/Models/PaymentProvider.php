<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\CompanyScope;
use App\Scopes\BranchScope;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class PaymentProvider extends Model
{
        use HasApiTokens, HasFactory, HasRoles, SoftDeletes;


    protected $fillable = [
        'company_id',
        'branch_id',
        'name',
        'code',
        'accounts_receivable',
        'is_active',
    ];



    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // Si necesitas ver las ventas asociadas a este proveedor
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function accountReceivables()
    {
        return $this->hasMany(AccountReceivable::class);
    }

      protected static function booted()
    {
        static::addGlobalScope(new CompanyScope());
       // static::addGlobalScope(new BranchScope());
    }
}
