<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\CompanyScope;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
class Supplier extends Model
{
    use HasApiTokens, HasFactory, HasRoles, SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'document',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'active'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope());
    }


    public function users()
    {
        return $this->hasMany(User::class);
    }

}
