<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class EnsureBranchIsActive
{
    public function handle(Request $request, Closure $next)
    {
        // Si usas sanctum / passport el usuario viene en $request->user()
        $user = $request->user();

        if (!$user || !$user->branch_id) {
            return response()->json([
                'message' => 'Usuario sin sucursal asignada.'
            ], 403);
        }

        $branch = Branch::find($user->branch_id);

        if (!$branch || !$branch->active) {
            return response()->json([
                'message' => 'Sucursal_inactiva'
            ], 403);
        }

        // Deja pasar la petición
        return $next($request);
    }
}
