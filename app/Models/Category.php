<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Category extends Model
{
     use HasApiTokens, HasFactory, HasRoles, SoftDeletes;

    protected $fillable = [
        'company_id',
        'parent_id',
        'name',
        'description'
    ];

    /** Relación: la categoría pertenece a una empresa */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /** Relación: la categoría padre */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /** Relación: subcategorías hijas */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /** Relación: productos asociados a esta categoría */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
