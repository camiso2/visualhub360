<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Services\RolePermissionService;

use App\Custom\ApiResponseTrait;
use Illuminate\Support\Facades\Log;

class CompanyRoleSetupController extends Controller
{

    use ApiResponseTrait;
    /**
     * @OA\Post(
     *     path="/api/companies/{id}/roles/setup",
     *     summary="Inicializa roles y permisos base para una empresa",
     *     tags={"Roles y Permisos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la empresa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Roles y permisos creados correctamente"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No autorizado para esta acción"
     *     )
     * )
     */
    public function setup(Request $request, $id)
    {

        try {
            $admin = auth()->user();

            // Solo el admin general (sin role_id) puede ejecutar esto
            if ($admin->role_id !== null) {
                // return response()->json(['error' => 'No tiene permisos para esta acción'], 403);
                return response()->json($this->unauthorized('No tiene permisos para esta acción'), status: 403);
            }

            $company = Company::findOrFail($id);

            // Usamos el nuevo servicio
            $roleService = new RolePermissionService();
            $roleService->initializeForCompany($company);

            /*return response()->json([
                'message' => 'Roles y permisos inicializados correctamente para la empresa',
                'company' => $company->name
            ]);*/
            // return response()->json(['message' => 'Sesión cerrada con éxito']);
            return response()->json($this->successfullMessage(
                201,
                'Roles y permisos inicializados correctamente para la empresa',
                true,
                1,
                ['company' => $company->name]
            ), 201);

        } catch (\Exception $e) {
            Log::info("Error exception ./" . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error exception'), 500);
        }
    }
}
