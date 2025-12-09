<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Company extends Model
{
    use HasApiTokens, HasFactory, HasRoles, SoftDeletes;

    protected $fillable = [
        'vh_code', 'name', 'legal_name', 'document_type', 'document_number',
        'dv', 'email', 'phone', 'website', 'address', 'neighborhood', 'city',
        'department', 'country', 'tax_regime', 'economic_activity_code',
        'billing_resolution', 'billing_resolution_date', 'is_verified',
        'active', 'logo_path', 'color_theme', 'verified_at'
    ];

    // Generar vh_code automáticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($company) {
            if (empty($company->vh_code)) {
                $company->vh_code = 'VH-' . strtoupper(substr(uniqid(), -8));
            }
        });
    }

    /** Relaciones */
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
