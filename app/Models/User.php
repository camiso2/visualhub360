<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use App\Scopes\CompanyScope;
use App\Scopes\BranchScope;



class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, HasRoles, SoftDeletes;

    protected $guard_name = 'api';


    protected $fillable = [
        'company_id',
        'branch_id',
        'role_id',
        'name',
        'avatar',
        'email',
        'password',
        'phone',
        'address',
        'document_type',
        'document_number',
        'city',
        'department',
        'active'
    ];

    protected $hidden = ['password', 'remember_token'];

    /** Relaciones */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function suppliers()
    {
        return $this->belongsTo(Branch::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    /*public function getJWTCustomClaims()
    {
        return [];
    }*/

    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope());

        // Aislamiento por SUCURSAL (branch_id), con excepción para Admin General
        static::addGlobalScope(new BranchScope());
    }


    public function getJWTCustomClaims()
    {
        //CRÍTICO: El valor se inyectará en el controlador justo antes de generar el token.
        // Aquí solo declaramos la llave.
        return [
            'active_branch_id' => $this->branch_id ?? null,
        ];
    }

    public function getRolesAttribute($value)
{
    // Lógica del accesor (ej: retornar la relación o una colección modificada)
    return $this->roles()->get();
}


}
