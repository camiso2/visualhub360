<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class SyncLog extends Model
{
    use HasApiTokens, HasFactory, HasRoles;

    protected $fillable = [
        'company_id', 'branch_id', 'vh_code', 'sync_type', 'details', 'synced_at'
    ];

    protected $casts = [
        'details' => 'array',
        'synced_at' => 'datetime'
    ];

    /** Relaciones */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
