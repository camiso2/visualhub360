<?php


namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Request;

/*class BranchScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        // 1. Obtener el token del encabezado de la solicitud (Request) para evitar recursión.
        $token = Request::header('Authorization');

        if ($token && str_starts_with($token, 'Bearer ')) {
            $token = substr($token, 7);

            try {
                // 2. Extraer el payload para leer el 'active_branch_id'
                $payload = JWTAuth::setToken($token)->getPayload();
                $activeBranchId = $payload->get('active_branch_id');

                // 3. BLINDAJE CRÍTICO: SOLO aplicar el filtro si el ID es numérico.
                // Si es NULL (usuario sin sucursal), esta condición es falsa y NO se aplica el WHERE.
                if (is_numeric($activeBranchId)) {
                    $builder->where($model->getTable() . '.branch_id', $activeBranchId);
                }

            } catch (\Exception $e) {
                // Si falla la decodificación del token (ej. expirado, corrupto),
                // el scope simplemente retorna sin aplicar el filtro.
                return;
            }
        }
    }
}*/

// app/Scopes/BranchScope.php


class BranchScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $table = $model->getTable();

            // 🛑 LÓGICA NO RECURSIVA 🛑
            // Asumimos que si el branch_id del usuario es NULL, es el Admin General.
            // Si el Admin General es User ID 1: $isAdminGeneral = ($user->id === 1);
            $isAdminGeneral = ($user->branch_id === null);

            // Si el usuario tiene una branch_id (NO es NULL) Y NO es el Administrador General.
            if ($user->branch_id !== null && !$isAdminGeneral) {
                 // Aquí se aplica el filtro, y solo a tablas que tienen 'branch_id'.
                 // Agregamos una comprobación de tabla para evitar problemas en tablas de Spatie.
                 if ($table !== 'roles' && $table !== 'permissions' && $table !== 'model_has_roles' && $table !== 'role_has_permissions') {
                    $builder->where("{$table}.branch_id", $user->branch_id);
                 }
            }
        }
    }
}

/*class BranchScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $table = $model->getTable();

            // 1. Asume que el Administrador General es el único rol que NO debe filtrar por Branch.
            // 2. Si el Administrador General no tiene un role_id asignado (o tiene un ID/nombre específico).

            // Lógica basada en el rol que NO debe filtrar (el Admin General)
            $isAdminGeneral = $user->hasRole('Administrador General');

            // Si el usuario tiene una branch_id Y NO es el Administrador General, aplicamos el filtro.
            if ($user->branch_id && !$isAdminGeneral) {
                 $builder->where("{$table}.branch_id", $user->branch_id);
            }
            // Si el usuario es el Administrador General, no se añade el filtro de branch_id.

            // NOTA: Si usas la columna role_id del modelo User (y es NULL para Admin General),
            // la lógica es: if ($user->branch_id && $user->role_id !== null) { ... }
        }
    }
}*/
