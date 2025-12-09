<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Custom\ApiResponseTrait;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

class BranchController extends Controller
{
    use ApiResponseTrait; // Si estás usando tu trait de respuestas

    /**
     * @OA\Get(
     * path="/api/branchess",
     * tags={"Branches"},
     * summary="Obtener lista paginada y filtrada de Sucursales",
     * tags={"Gestión de Sucursales"},
     * description="Recupera un listado de sucursales con soporte para búsqueda, paginación y ordenamiento.",
     * security={{"bearerAuth": {}}},
     * * @OA\Parameter(
     * name="search",
     * in="query",
     * description="Término de búsqueda para filtrar por name, code, phone, email, address, city o department.",
     * required=false,
     * @OA\Schema(type="string")
     * ),
     * @OA\Parameter(
     * name="per_page",
     * in="query",
     * description="Número de elementos por página (default: 10).",
     * required=false,
     * @OA\Schema(type="integer", default=10)
     * ),
     * @OA\Parameter(
     * name="page",
     * in="query",
     * description="Número de página a recuperar (default: 1).",
     * required=false,
     * @OA\Schema(type="integer", default=1)
     * ),
     * @OA\Parameter(
     * name="sort_by",
     * in="query",
     * description="Campo para ordenar (ej: name, created_at) (default: created_at).",
     * required=false,
     * @OA\Schema(type="string", default="created_at")
     * ),
     * @OA\Parameter(
     * name="sort_direction",
     * in="query",
     * description="Dirección del ordenamiento ('asc' o 'desc') (default: desc).",
     * required=false,
     * @OA\Schema(type="string", enum={"asc", "desc"}, default="desc")
     * ),
     * * @OA\Response(
     * response=200,
     * description="Lista de sucursales obtenida exitosamente.",
     * @OA\JsonContent(
     * @OA\Property(property="code", type="integer", example=200),
     * @OA\Property(property="message", type="string", example="Sucursales obtenidas correctamente"),
     * @OA\Property(property="status", type="boolean", example=true),
     * @OA\Property(property="total", type="integer", example=50),
     * @OA\Property(
     * property="data",
     * type="object",
     * @OA\Property(
     * property="branches",
     * type="object",
     * description="Objeto de paginación de Laravel.",
     * )
     * )
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Error interno del servidor."
     * )
     * )
     */
    public function listBranches(Request $request)
    {
        try {
            // 1. Obtener parámetros de la solicitud
            $search = $request->input('search');
            $perPage = $request->input('per_page', 10); // Valor por defecto: 10
            $sortBy = $request->input('sort_by', 'created_at'); // Campo de ordenamiento por defecto
            $sortDirection = $request->input('sort_direction', 'desc'); // Dirección por defecto

            // 2. Iniciar la consulta
            $query = Branch::query();

            // 3. Aplicar filtro de búsqueda
            if ($search) {
                // Se busca por name, code, phone, email, address, city o department
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('code', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('address', 'like', '%' . $search . '%')
                        ->orWhere('city', 'like', '%' . $search . '%')
                        ->orWhere('department', 'like', '%' . $search . '%');
                });
            }

            // 4. Aplicar ordenamiento
            // Se valida la dirección para prevenir inyección SQL simple
            $sortDirection = in_array(strtolower($sortDirection), ['asc', 'desc']) ? $sortDirection : 'desc';
            $query->orderBy($sortBy, $sortDirection);

            // 5. Aplicar paginación
            // El método paginate automáticamente obtiene el 'page' del request
            $branches = $query->paginate($perPage);

            // 6. Preparar la respuesta paginada
            // paginate() devuelve un objeto que incluye la data, total, current_page, etc.
            return response()->json(
                $this->successfullMessage(
                    200, // Código 200 para GET exitoso
                    'Sucursales obtenidas correctamente',
                    true,
                    $branches->total(), // Total de registros
                    ['branches' => $branches] // La data de paginación
                ),
                200
            );

        } catch (\Exception $e) {
            Log::error("Error listing branches: " . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error exception'), 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/admin/branches",
     *     summary="Crear una nueva sucursal asociada a la empresa del admin",
     *     tags={"Gestión de Sucursales"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string", example="Sucursal Centro"),
     *                 @OA\Property(property="phone", type="string", example="3001234567"),
     *                 @OA\Property(property="email", type="string", format="email", example="sucursal@empresa.com"),
     *                 @OA\Property(property="image", type="string", format="binary", description="Imagen opcional de la sucursal"),
     *                 @OA\Property(property="address", type="string", example="Calle 123 #45-67"),
     *                 @OA\Property(property="city", type="string", example="Bogotá"),
     *                 @OA\Property(property="department", type="string", example="Cundinamarca"),
     *                 @OA\Property(property="active", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Sucursal creada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sucursal creada correctamente"),
     *             @OA\Property(property="branch", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="company_id", type="integer", example=44),
     *                 @OA\Property(property="name", type="string", example="Sucursal Centro"),
     *                 @OA\Property(property="code", type="string", example="A1B2C3"),
     *                 @OA\Property(property="phone", type="string", example="3001234567"),
     *                 @OA\Property(property="email", type="string", example="sucursal@empresa.com"),
     *                 @OA\Property(property="image", type="string", example="/branches/uuid.jpg"),
     *                 @OA\Property(property="address", type="string", example="Calle 123 #45-67"),
     *                 @OA\Property(property="city", type="string", example="Bogotá"),
     *                 @OA\Property(property="department", type="string", example="Cundinamarca"),
     *                 @OA\Property(property="active", type="boolean", example=true),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No tiene permisos para crear sucursales")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function createBranch(Request $request)
    {
        try {
            $admin = auth()->user();
            if ($request->has('active')) {
                $request->merge([
                    'active' => filter_var($request->active, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
                ]);
            }

            // Validación de campos
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'email' => [
                    'nullable',
                    'email',
                    'max:255',
                    Rule::unique('branches')->ignore(null)->where(fn($query) => $query->where('company_id', $admin->company_id)),
                ],
                'image' => 'required|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:50',
                'department' => 'nullable|string|max:50',
                'active' => 'nullable|boolean'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    $this->errorMessage(
                        422,
                        'Error de validación',
                        [
                            'errors' => $validator->errors()
                        ]
                    ),
                    422
                );
            }

            // Manejo de imagen
            $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('branches'), $filename);
                $imagePath = '/branches/' . $filename;
            }

            // Generar código único para la sucursal usando scope global
            do {
                $code = strtoupper(Str::random(6));
            } while (Branch::where('code', $code)->exists()); // CompanyScope ya filtra automáticamente

            // Crear sucursal
            $branch = Branch::create([
                'company_id' => $admin->company_id,
                'name' => $request->name,
                'code' => $code,
                'phone' => $request->phone,
                'email' => $request->email,
                'image' => $imagePath,
                'address' => $request->address,
                'city' => $request->city,
                'department' => $request->department,
                'active' => $request->active ?? true,
            ]);

            return response()->json(
                $this->successfullMessage(
                    201,
                    'Sucursal creada correctamente',
                    true,
                    1,
                    ['branch' => $branch, 'user' => $admin,]
                ),
                201
            );

        } catch (\Exception $e) {
            Log::error("Error creating branch: " . $e->getMessage());
            return response()->json(
                $this->eMessageError($e->getMessage(), 'Error exception'),
                500
            );
        }
    }


    /**
     * @OA\Post(
     *     path="/api/admin/branches/{branch}",
     *     summary="Actualizar una sucursal de la empresa del admin",
     *     tags={"Gestión de Sucursales"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="branch",
     *         in="path",
     *         required=true,
     *         description="ID de la sucursal a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string", example="Sucursal Norte"),
     *                 @OA\Property(property="phone", type="string", example="3201234567"),
     *                 @OA\Property(property="email", type="string", format="email", example="norte@empresa.com"),
     *                 @OA\Property(property="image", type="string", format="binary", description="Nueva imagen opcional"),
     *                 @OA\Property(property="address", type="string", example="Carrera 10 #45-30"),
     *                 @OA\Property(property="city", type="string", example="Medellín"),
     *                 @OA\Property(property="department", type="string", example="Antioquia"),
     *                 @OA\Property(property="active", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sucursal actualizada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sucursal actualizada correctamente"),
     *             @OA\Property(property="branch", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="company_id", type="integer", example=44),
     *                 @OA\Property(property="name", type="string", example="Sucursal Norte"),
     *                 @OA\Property(property="code", type="string", example="A1B2C3"),
     *                 @OA\Property(property="phone", type="string", example="3201234567"),
     *                 @OA\Property(property="email", type="string", example="norte@empresa.com"),
     *                 @OA\Property(property="image", type="string", example="/branches/uuid.jpg"),
     *                 @OA\Property(property="address", type="string", example="Carrera 10 #45-30"),
     *                 @OA\Property(property="city", type="string", example="Medellín"),
     *                 @OA\Property(property="department", type="string", example="Antioquia"),
     *                 @OA\Property(property="active", type="boolean", example=true),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No autorizado",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="No tiene permisos para actualizar esta sucursal"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sucursal no encontrada",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Sucursal no encontrada"))
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(@OA\Property(property="errors", type="object"))
     *     )
     * )
     */
    public function updateBranch(Request $request, $id)
    {
        try {
            $user = auth()->user();
            if ($request->has('active')) {
                $request->merge([
                    'active' => filter_var($request->active, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
                ]);
            }
            Log::info('Update branch: usuario autenticado', [
                'user_id' => $user->id,
                'company_id' => $user->company_id
            ]);
            $branch = Branch::withoutGlobalScope(\App\Scopes\CompanyScope::class)
                ->where('company_id', $user->company_id)
                ->where('id', $id)
                ->first();

            if (!$branch) {
                return response()->json(
                    $this->errorGeneric('Sucursal no encontrada o no pertenece a su empresa', 404),
                    404
                );
            }
            Log::info('Sucursal encontrada', ['branch_id' => $branch->id]);
            // Validaciones
            $validator = Validator::make($request->all(), [
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'name' => 'sometimes|required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'department' => 'nullable|string|max:100',
                'active' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    $this->errorMessage(
                        422,
                        'Error de validación',
                        [
                            'errors' => $validator->errors()
                        ]
                    ),
                    422
                );
            }
            // Manejo de imagen
            // Manejo de imagen
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('branches'), $filename);

                $imagePath = '/branches/' . $filename;

                // Eliminar imagen anterior
                if ($branch->image && File::exists(public_path($branch->image))) {
                    File::delete(public_path($branch->image));
                }

                $branch->image = $imagePath; // ← Aquí se asigna correctamente
            }

            // Actualizar otros campos
            $branch->fill([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'department' => $request->department,
                'active' => $request->active,
            ]);

            // Guardar TODO (incluyendo imagen)
            $branch->save();


            return response()->json(
                $this->successfullMessage(
                    200,
                    'Sucursal actualizada correctamente',
                    true,
                    1,
                    ['branch' => $branch]
                )
            );

        } catch (\Exception $e) {
            Log::error("Error en updateBranch: " . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error al actualizar la sucursal'), 500);
        }
    }


    /**
     * @OA\Delete(
     *     path="/api/admin/branch/{id}",
     *     summary="Eliminar una sucursal (solo admin global)",
     *     tags={"Gestión de Sucursales"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la sucursal a eliminar",
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sucursal eliminada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Sucursal eliminada correctamente"),
     *             @OA\Property(property="success", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No tiene permisos para eliminar esta sucursal",
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="integer", example=403),
     *             @OA\Property(property="message", type="string", example="No tiene permisos para eliminar esta sucursal"),
     *             @OA\Property(property="success", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sucursal no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="Sucursal no encontrada o no pertenece a su empresa"),
     *             @OA\Property(property="success", type="boolean", example=false)
     *         )
     *     )
     * )
     */
    public function deleteBranch($id)
    {
        try {
            $admin = auth()->user();

            // Solo el admin  (role_id == null)
            if ($admin->role_id !== null) {
                return response()->json($this->errorGeneric('No tiene permisos para eliminar sucursales', 403), 403);
            }

            $branch = Branch::withoutGlobalScope(\App\Scopes\CompanyScope::class)
                ->where('company_id', $admin->company_id)
                ->where('id', $id)
                ->first();

            if (!$branch) {
                return response()->json(
                    $this->errorGeneric('Sucursal no encontrada o no pertenece a su empresa', 404),
                    404
                );
            }

            // Buscar la sucursal sin scopes
            $branch = Branch::withoutGlobalScopes()->find($id);

            if (!$branch) {
                return response()->json($this->errorGeneric('Sucursal no encontrada', 404), 404);
            }

            $branch->delete();

            return response()->json(
                $this->successfullMessage(
                    200,
                    'Sucursal eliminada correctamente',
                    true,
                    0
                )
            );

        } catch (\Exception $e) {
            Log::error("Error deleting branch: " . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error exception'), 500);
        }
    }



    /**
     * @OA\Post(
     *     path="/api/admin/branch/{id}/restore",
     *     summary="Restaurar una sucursal eliminada (solo admin global)",
     *     tags={"Gestión de Sucursales"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la sucursal a restaurar",
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sucursal restaurada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Sucursal restaurada correctamente"),
     *             @OA\Property(property="success", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No tiene permisos para restaurar sucursales",
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="integer", example=403),
     *             @OA\Property(property="message", type="string", example="No tiene permisos para restaurar sucursales"),
     *             @OA\Property(property="success", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sucursal no encontrada o no pertenece a su empresa",
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="Sucursal no encontrada o no pertenece a su empresa"),
     *             @OA\Property(property="success", type="boolean", example=false)
     *         )
     *     )
     * )
     */
    public function restoreBranch($id)
    {
        try {
            $admin = auth()->user();

            // Solo el admin global puede restaurar
            if ($admin->role_id !== null) {
                return response()->json($this->errorGeneric('No tiene permisos para restaurar sucursales', 403), 403);
            }

            // Buscar la sucursal eliminada de su empresa
            $branch = Branch::onlyTrashed()
                ->withoutGlobalScope(\App\Scopes\CompanyScope::class)
                ->where('company_id', $admin->company_id)
                ->where('id', $id)
                ->first();

            if (!$branch) {
                return response()->json(
                    $this->errorGeneric('Sucursal no encontrada o no pertenece a su empresa', 404),
                    404
                );
            }

            $branch->restore();

            return response()->json(
                $this->successfullMessage(
                    200,
                    'Sucursal restaurada correctamente',
                    true,
                    1,
                    ['branch' => $branch]
                )
            );

        } catch (\Exception $e) {
            Log::error("Error restoring branch: " . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error exception'), 500);
        }
    }

}
