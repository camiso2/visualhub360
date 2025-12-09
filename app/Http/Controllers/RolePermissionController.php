<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Custom\ApiResponseTrait;
use Illuminate\Support\Facades\Log;

class RolePermissionController extends Controller
{

    use ApiResponseTrait;

    /**
     * @OA\Get(
     *     path="/api/roles",
     *     summary="Listar todos los roles con sus permisos",
     *     tags={"Roles y Permisos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de roles con sus permisos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Administrador General"),
     *                 @OA\Property(
     *                     property="permissions",
     *                     type="array",
     *                     @OA\Items(type="string", example="ver_usuarios")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getRoles()
    {
        try {
            $admin = auth()->user();

            $roles = Role::with('permissions')
                ->where('company_id', $admin->company_id)
                ->where('name', '!=', 'Administrador General') // ← EXCLUIDO
                ->where('name', '!=', 'Cliente') // ← EXCLUIDO
                ->get();

            return response()->json($this->successfullMessage(
                201,
                'Lista de roles en la empresa',
                true,
                $roles->count(),
                ['roles' => $roles]
            ), 201);

        } catch (\Exception $e) {
            Log::info("Error exception ./" . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error exception'), 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/permissions",
     *     summary="Listar todos los permisos disponibles",
     *     tags={"Roles y Permisos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de permisos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="ver_clientes"),
     *                 @OA\Property(property="guard_name", type="string", example="api")
     *             )
     *         )
     *     )
     * )
     */
    public function getPermissions()
    {
        try {
            $admin = auth()->user();
            /*if ($admin->role_id !== null) {
                return response()->json(['error' => 'No tiene permisos para esta acción'], 403);
            }*/
            $permissions = Permission::all();
            //return response()->json($permissions);
            return response()->json($this->successfullMessage(
                201,
                'Lista de permisos en la empresa',
                true,
                $permissions->count(),
                ['permissions' => $permissions]
            ), 201);

        } catch (\Exception $e) {
            Log::info("Error exception ./" . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error exception'), 500);
        }
    }

    /*public function assignPermissions(Request $request, $roleId)
   {
       $admin = auth()->user();

       // Solo el admin general (sin role_id) puede modificar permisos
       if ($admin->role_id !== null) {
           return response()->json(['error' => 'No tiene permisos para esta acción'], 403);
       }

       $role = Role::findOrFail($roleId);

       $validated = $request->validate([
           'permissions' => 'required|array',
           'permissions.*' => 'string|exists:permissions,name'
       ]);

       $role->syncPermissions($validated['permissions']);

       return response()->json([
           'message' => 'Permisos actualizados correctamente',
           'role' => $role->name,
           'permissions' => $role->permissions->pluck('name')
       ]);
   }*/

}
