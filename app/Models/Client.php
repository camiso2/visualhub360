<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

use App\Scopes\CompanyScope;
use App\Scopes\BranchScope;

class Client extends Model
{
    use HasApiTokens, HasFactory, HasRoles, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'branch_code',
        'name',
        'email',
        'phone',
        'document_type',
        'document_number',
        'address',
        'city',
        'department',
        'active',

    ];


    public function documents()
    {
        return $this->hasMany(DocumentsClients::class);
    }

    protected $dates = ['deleted_at'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Summary of booted
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope());

        // Aislamiento por SUCURSAL (branch_id), con excepción para Admin General
        //static::addGlobalScope(new BranchScope());
    }

    /**
     * Summary of scopeByDocumentNumber
     * @param mixed $query
     * @param mixed $documentNumber
     */
    public function scopeByDocumentNumber($query, $documentNumber)
    {
        return $query->where('document_number', $documentNumber);
        //->where('company_id', auth()->user()->company_id);
    }
}

