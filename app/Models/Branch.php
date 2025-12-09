<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Scopes\CompanyScope;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Branch extends Model
{
use HasApiTokens, HasFactory, HasRoles, SoftDeletes;
    protected $fillable = [
        'company_id',  'name', 'code', 'phone', 'email','image',
        'address', 'city', 'department', 'active'
    ];

    /** Relaciones */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope());
    }
}
