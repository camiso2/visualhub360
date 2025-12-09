<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Scopes\CompanyScope; //Importa tu scope global
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class DocumentsClients extends Model
{
    use HasApiTokens, HasFactory, HasRoles, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'user_id',
        'client_id',
        'name_company',
        'description',
        'image_id',
    ];

    protected $casts = [
        'image_id' => 'array',
    ];

    /**
     * ==========================================================
     * RELACIONES
     * ==========================================================
     */

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * ==========================================================
     * SCOPES PERSONALIZADOS
     * ==========================================================
     * // Ejemplos de uso:
     * // Documentos de la sucursal del usuario autenticado
     * DocumentClient::byBranch()->get();
     * // Documentos de un cliente específico
     * DocumentClient::byClient($clientId)->get();
     */

    // Filtra por sucursal del usuario autenticado
    public function scopeByBranch(Builder $query): Builder
    {
        $user = auth()->user();
        if ($user && $user->branch_id) {
            return $query->where('branch_id', $user->branch_id);
        }
        return $query;
    }

    // Filtra documentos por cliente específico
    public function scopeByClient(Builder $query, int $clientId): Builder
    {
        return $query->where('client_id', $clientId);
    }



    public function images()
    {
        return $this->hasMany(ImageDocumentsClient::class, 'client_id', 'client_id')
            ->whereColumn('company_id', 'documents_clients.company_id');
    }
    /**
     * ==========================================================
     * SCOPE GLOBAL (CompanyScope)
     * ==========================================================
     */
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope());
    }
}
