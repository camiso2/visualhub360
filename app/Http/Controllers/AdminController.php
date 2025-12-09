<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Models\Permission;
use App\Custom\ApiResponseTrait;
use App\Custom\HasCompanyScope;
use App\Scopes\CompanyScope;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;


class AdminController extends Controller
{
    use ApiResponseTrait;
    use HasCompanyScope;

    /**
     * @OA\Post(
     *     path="/api/admin/create-user",
     *     summary="Crear un usuario por parte del administrador (misma empresa)",
     *     tags={"Gestión de Usuarios Administración"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name","email","phone","address","city","department","document_type","document_number","password"},
     *                 @OA\Property(
     *                     property="avatar",
     *                     type="string",
     *                     format="binary",
     *                     description="Archivo de imagen del avatar"
     *                 ),
     *                 @OA\Property(property="name", type="string", example="Juan Perez"),
     *                 @OA\Property(property="email", type="string", format="email", example="juan@example.com"),
     *                 @OA\Property(property="phone", type="string", example="300 1234567"),
     *                 @OA\Property(property="address", type="string", example="Calle 123 #45-67"),
     *                 @OA\Property(property="city", type="string", example="Bogotá"),
     *                 @OA\Property(property="department", type="string", example="Cundinamarca"),
     *                 @OA\Property(property="document_type", type="string", example="CC"),
     *                 @OA\Property(property="document_number", type="string", example="12345678"),
     *                 @OA\Property(property="password", type="string", format="password", example="12345678"),
     *                 @OA\Property(
     *                     property="role_name",
     *                     type="string",
     *                     example="Asesor Interno",
     *                     description="Nombre del rol del usuario. Si no se envía, se asigna 'Asesor Interno' por defecto"
     *                 ),
     *                 @OA\Property(property="branch_id", type="integer", example=1),
     *                 @OA\Property(property="active", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario creado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario creado correctamente"),
     *             @OA\Property(property="user", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No tiene permisos para crear usuarios")
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

    public function createUser(Request $request)
    {
        try {
            $admin = auth()->user();

            Log::info("Admin ID {$admin->id} intenta crear un usuario en la empresa............... {$admin->all()}");

            /*if ($admin->role_id !== null) {
                return response()->json($this->errorGeneric('No tiene permisos para crear usuarios', 403), 403);
            }*/

            if ($request->has('active')) {
                $request->merge([
                    'active' => filter_var($request->active, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
                ]);
            }

            $validator = Validator::make($request->all(), [
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|min:8',
                'address' => 'required|string|min:8|max:80',
                'city' => 'required|string|min:3|max:50',
                'department' => 'required|string|min:3|max:50',
                'document_type' => 'required|string|min:1|max:12',
                'document_number' => 'required|string|min:7|max:12',
                'password' => 'required|string|min:6',
                'role_name' => 'required|string',
                'branch_id' => 'required|exists:branches,id',
                'active' => 'nullable|boolean'
            ]);

            if ($validator->fails()) {
                // return response()->json($this->validationError($validator->errors()), 422);
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

            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('avatars'), $filename);
                $avatarPath = '/avatars/' . $filename;
            }

            $role = Role::where('name', $request->role_name)
                ->where('company_id', $admin->company_id)
                ->first();

            if (!$role) {
                return response()->json($this->errorGeneric("Rol no encontrado o no pertenece a la empresa", 403), 403);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'company_id' => $admin->company_id,
                'branch_id' => $request->branch_id ?? null,
                'role_id' => $role->id,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'department' => $request->department,
                'document_type' => $request->document_type,
                'document_number' => $request->document_number,
                'avatar' => $avatarPath,
                'active' => $request->active ?? true,
            ]);

            // Asignar rol
            $user->assignRole($role->name);

            // Limpiar cache y refrescar relaciones
            app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
            $user->refresh();

            // Asignar permisos del rol directamente
            foreach ($role->permissions as $permission) {
                $user->givePermissionTo($permission->name);
            }


            return response()->json(
                $this->successfullMessage(
                    201,
                    'Usuario creado correctamente, rol y permisos asignados',
                    true,
                    1,
                    [
                        'user' => $user,
                        'rol' => $role->name,
                        'permisos' => $user->getAllPermissions()->pluck('name'),
                    ]
                ),
                201
            );


        } catch (\Exception $e) {
            Log::error("Error exception: " . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error exception'), 500);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/admin/users/{user}",
     *     summary="Actualizar datos personales y rol de un usuario",
     *     tags={"Gestión de Usuarios Administración"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="ID del usuario a actualizar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="avatar", type="string", format="binary", description="Archivo de imagen del avatar"),
     *                 @OA\Property(property="name", type="string", example="Juan Perez"),
     *                 @OA\Property(property="phone", type="string", example="300 1234567"),
     *                 @OA\Property(property="address", type="string", example="Calle 123 #45-67"),
     *                 @OA\Property(property="city", type="string", example="Bogotá"),
     *                 @OA\Property(property="department", type="string", example="Cundinamarca"),
     *                 @OA\Property(property="document_type", type="string", example="CC"),
     *                 @OA\Property(property="document_number", type="string", example="12345678"),
     *                 @OA\Property(property="password", type="string", format="password", example="12345678"),
     *                 @OA\Property(property="role_name", type="string", example="Asesor Interno"),
     *                 @OA\Property(property="branch_id", type="integer", example=1),
     *                 @OA\Property(property="active", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario actualizado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario actualizado correctamente"),
     *             @OA\Property(property="user", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No tiene permisos para actualizar usuarios")
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
    public function updateUser(Request $request, $userId)
    {
        try {
            $admin = auth()->user();
            // Buscar usuario limitado por CompanyScope automáticamente
            $user = User::find($userId);
            if (!$user) {
                return response()->json($this->errorGeneric('Usuario no encontrado o no pertenece a su empresa', 403), 403);
            }

            // Validar permisos: solo admin de la misma empresa puede actualizar
            if ($admin->role_id !== null && $admin->company_id !== $user->company_id) {
                return response()->json($this->errorGeneric('No tiene permisos para actualizar este usuario', 403), 403);
            }

            // Normalizar campo 'active' si viene
            if ($request->has('active')) {
                $request->merge([
                    'active' => filter_var($request->active, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
                ]);
            }

            // Validación de request
            $validator = Validator::make($request->all(), [
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'name' => 'sometimes|required|string|max:255',
                //'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
                'phone' => 'sometimes|required|string|min:8',
                'address' => 'sometimes|required|string|min:8|max:80',
                'city' => 'sometimes|required|string|min:3|max:50',
                'department' => 'sometimes|required|string|min:3|max:50',
                'document_type' => 'sometimes|required|string|min:1|max:12',
                //'document_number' => 'sometimes|required|string|min:7|max:12',
                'password' => 'nullable|string|min:6',
                'role_name' => 'nullable|string',
                //'branch_id' => 'nullable|exists:branches,id',
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

            // Manejo de avatar
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('avatars'), $filename);
                $avatarPath = '/avatars/' . $filename;

                // Eliminar avatar anterior si existe
                if ($user->avatar && File::exists(public_path($user->avatar))) {
                    File::delete(public_path($user->avatar));
                }

                $user->avatar = $avatarPath;
            }

            // Actualizar campos opcionales
            $fields = ['name', 'email', 'phone', 'address', 'city', 'department', 'document_type', 'document_number', 'branch_id', 'active'];
            foreach ($fields as $field) {
                if ($request->has($field)) {
                    $user->{$field} = $request->{$field};
                }
            }

            // Actualizar password si viene
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            // Asegurar company_id
            if (!$user->company_id) {
                $user->company_id = $admin->company_id;
            }

            // Actualizar rol si viene
            if ($request->filled('role_name')) {
                $role = Role::where('name', $request->role_name)
                    ->where('company_id', $admin->company_id)
                    ->first();

                if (!$role) {
                    return response()->json($this->errorGeneric("Rol no encontrado o no pertenece a la empresa", 403), 403);
                }

                $user->role_id = $role->id;
                $user->syncRoles($role->name);

                // Asignar permisos del rol directamente, manteniendo permisos existentes
                foreach ($role->permissions as $permission) {
                    if (!$user->hasPermissionTo($permission->name)) {
                        $user->givePermissionTo($permission->name);
                    }
                }
            }

            // Guardar cambios
            $user->save();
            $user->refresh();

            return response()->json(
                $this->successfullMessage(
                    200,
                    'Usuario actualizado correctamente',
                    true,
                    1,
                    [
                        'user' => $user->load('roles', 'permissions'),
                        'rol' => $user->roles->pluck('name')->first(),
                        'permisos' => $user->getAllPermissions()->pluck('name'),
                    ]
                )
            );

        } catch (\Exception $e) {
            Log::error("Error exception: " . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error exception'), 500);
        }
    }


    /**
     * @OA\Delete(
     *     path="/api/admin/users/{user}",
     *     summary="Eliminar un usuario (solo admin de la misma empresa)",
     *     tags={"Gestión de Usuarios Administración"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="ID del usuario a eliminar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario eliminado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No tiene permisos para eliminar este usuario")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Usuario no encontrado o no pertenece a su empresa")
     *         )
     *     )
     * )
     */
    public function deleteUser($userId)
    {
        try {
            $admin = auth()->user();

            if ($admin->role_id !== null) {
                return response()->json($this->errorGeneric('No tiene permisos para crear usuarios', 403), 403);
            }

            // Buscar usuario y validar que pertenece a la misma empresa del admin
            $user = User::withoutGlobalScope(CompanyScope::class)->find($userId);
            if (!$user || $user->company_id !== $admin->company_id) {
                return response()->json(
                    $this->errorGeneric('Usuario no encontrado o no pertenece a su empresa', 404),
                    404
                );
            }

            // Log antes de eliminar
            Log::info("El admin {$admin->id} elimina al usuario", ['userId' => $user->id, 'companyId' => $user->company_id]);

            // Eliminar usuario (soft delete)
            $user->delete();

            // eliminar físicamente, usa forceDelete()
            // $user->forceDelete();

            return response()->json(
                $this->successfullMessage(
                    200,
                    'Usuario eliminado correctamente',
                    true,
                    0
                )
            );

        } catch (\Exception $e) {
            Log::error("Error al eliminar usuario: " . $e->getMessage(), ['userId' => $userId, 'adminId' => $admin->id]);
            return response()->json($this->eMessageError($e->getMessage(), 'Error exception'), 500);
        }
    }



    /**
     * @OA\Patch(
     *     path="/api/admin/users/{user}/restore",
     *     summary="Restaurar un usuario eliminado (soft delete)",
     *     tags={"Gestión de Usuarios Administración"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="ID del usuario a restaurar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario restaurado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario restaurado correctamente"),
     *             @OA\Property(property="user", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="El usuario no está eliminado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="El usuario no está eliminado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado o no pertenece a su empresa",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Usuario no encontrado o no pertenece a su empresa")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error exception")
     *         )
     *     )
     * )
     */
    public function restoreUser($userId)
    {
        try {
            $admin = auth()->user();

            if ($admin->role_id !== null) {
                return response()->json($this->errorGeneric('No tiene permisos para crear usuarios', 403), 403);
            }

            // Buscar usuario incluso si está eliminado (soft deleted)
            $user = User::withTrashed()->find($userId);

            // Validar existencia y empresa
            if (!$user || $user->company_id !== $admin->company_id) {
                return response()->json(
                    $this->errorGeneric('Usuario no encontrado o no pertenece a su empresa', 404),
                    404
                );
            }

            // Validar que esté eliminado
            if (!$user->trashed()) {
                return response()->json(
                    $this->errorGeneric('El usuario no está eliminado', 400),
                    400
                );
            }

            // Restaurar usuario
            $user->restore();

            // Log de la acción
            Log::info("El admin {$admin->id} restauró al usuario", [
                'userId' => $user->id,
                'companyId' => $user->company_id,
                'adminId' => $admin->id
            ]);

            return response()->json(
                $this->successfullMessage(
                    200,
                    'Usuario restaurado correctamente',
                    true,
                    1,
                    [
                        'user' => $user->load('roles', 'permissions'),
                        'rol' => $user->roles->pluck('name')->first(),
                        'permisos' => $user->getAllPermissions()->pluck('name'),
                    ]
                )
            );

        } catch (\Exception $e) {
            Log::error("Error al restaurar usuario: " . $e->getMessage(), ['userId' => $userId, 'adminId' => $admin->id]);
            return response()->json($this->eMessageError($e->getMessage(), 'Error exception'), 500);
        }
    }


    /**
     * @OA\Get(
     * path="/api/users",
     * summary="Listar usuarios con paginación, búsqueda general y filtro por rol.",
     * tags={"Gestión de Usuarios Administración"},
     * security={{"bearerAuth":{}}},
     * * @OA\Parameter(
     * name="search",
     * in="query",
     * required=false,
     * description="Texto para filtrar usuarios por nombre, email, teléfono, dirección, ciudad, departamento o número de documento.",
     * @OA\Schema(type="string")
     * ),
     * @OA\Parameter(
     * name="role_name",
     * in="query",
     * required=false,
     * description="Nombre del rol por el cual filtrar (ej: 'admin', 'supervisor').",
     * @OA\Schema(type="string")
     * ),
     * @OA\Parameter(
     * name="per_page",
     * in="query",
     * required=false,
     * description="Cantidad de usuarios por página para paginación (default: 10).",
     * @OA\Schema(type="integer", example=10)
     * ),
     * * @OA\Response(
     * response=200,
     * description="Listado de usuarios de la compañía del administrador",
     * @OA\JsonContent(
     * @OA\Property(property="code", type="integer", example=200),
     * @OA\Property(property="message", type="string", example="Listado de usuarios obtenido correctamente"),
     * @OA\Property(property="success", type="boolean", example=true),
     * @OA\Property(property="count", type="integer", description="Total de registros", example=50),
     * @OA\Property(property="data", type="object",
     * @OA\Property(property="users", type="object",
     * description="Objeto Paginador de Laravel",
     * @OA\Property(property="current_page", type="integer", example=1),
     * @OA\Property(property="data", type="array",
     * @OA\Items(
     * @OA\Property(property="id", type="integer", example=1),
     * @OA\Property(property="name", type="string", example="Juan Pérez"),
     * @OA\Property(property="email", type="string", example="juan@ejemplo.com"),
     * @OA\Property(property="document_number", type="string", example="1094000000"),
     * @OA\Property(property="roles", type="array", description="Roles asignados", @OA\Items(type="object")),
     * @OA\Property(property="permissions", type="array", description="Permisos asignados", @OA\Items(type="object"))
     * )
     * ),
     * @OA\Property(property="first_page_url", type="string"),
     * @OA\Property(property="last_page", type="integer", example=5),
     * @OA\Property(property="last_page_url", type="string"),
     * @OA\Property(property="next_page_url", type="string", nullable=true),
     * @OA\Property(property="path", type="string"),
     * @OA\Property(property="per_page", type="integer", example=10),
     * @OA\Property(property="prev_page_url", type="string", nullable=true),
     * @OA\Property(property="to", type="integer", example=10),
     * @OA\Property(property="total", type="integer", example=50)
     * )
     * )
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Usuario no autenticado",
     * @OA\JsonContent(
     * @OA\Property(property="code", type="integer", example=401),
     * @OA\Property(property="message", type="string", example="Usuario no autenticado"),
     * @OA\Property(property="success", type="boolean", example=false)
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Error interno del servidor"
     * )
     * )
     */
    public function listUsers(Request $request)
    {
        $admin = auth()->user();

        // =========================================================
        // OBTENER LOS ROLES DE LA MISMA COMPAÑÍA 🚀
        // =========================================================
        // Asumiendo que el modelo Role tiene una columna 'company_id' para filtrar
        $companyRoles = Role::where('company_id', $admin->company_id)
            ->select('id', 'name') // Solo necesitas ID y nombre para el frontend
            ->get();

        // 1. Verificar Autenticación
        if (!$admin) {
            // Devolver un error 401 Unauthorized si no hay usuario autenticado
            return response()->json($this->errorGeneric('Usuario no autenticado', 401), 401);
        }

        try {
            // 2. Inicializar la consulta base con relaciones
            $query = User::query()
                ->with(['roles', 'permissions', 'roles.permissions'])
                // Filtrar solo usuarios de la misma compañía
                ->where('company_id', $admin->company_id)
                ->orderBy('created_at', 'Desc');


            //LÓGICA DE FILTRADO POR ROL
            // =========================================================
            if ($request->filled('role_name')) {
                $roleName = $request->input('role_name');

                if (!empty($roleName)) {
                    $searchTerm = '%' . $roleName . '%'; // Prepara para LIKE

                    $query->whereHas('roles', function ($q) use ($searchTerm) {
                        // Permite coincidencias parciales.
                        $q->where('name', 'LIKE', $searchTerm)
                            ->orWhere('description', 'LIKE', $searchTerm);

                        // Si quieres que la búsqueda sea insensible a mayúsculas/minúsculas,
                        // usa ILIKE en PostgreSQL o LOWER(name) en MySQL/MariaDB:
                        // $q->whereRaw('LOWER(name) LIKE ?', [strtolower($searchTerm)]);
                    });
                }
            }

            // 3. Lógica de Búsqueda (Búsqueda opcional por nombre, email o documento)
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $searchTerm = '%' . $search . '%';
                    $q->where('name', 'like', $searchTerm)
                        ->orWhere('email', 'like', $searchTerm)
                        ->orWhere('phone', 'like', $searchTerm)
                        ->orWhere('address', 'like', $searchTerm)
                        ->orWhere('city', 'like', $searchTerm)
                        ->orWhere('department', 'like', $searchTerm)
                        ->orWhere('document_number', 'like', $searchTerm);
                });
            }

            // 4. Paginación
            // Obtener el número de elementos por página, por defecto 10
            $perPage = $request->input('per_page', 10);

            // Ejecutar la consulta con paginación
            $users = $query->paginate($perPage);



            // 5. Respuesta Exitosa
            // Devolver el objeto Paginator completo para facilitar el trabajo en el frontend
            return response()->json(
                $this->successfullMessage(
                    200,
                    'Listado de usuarios obtenido correctamente',
                    true,
                    $users->total(), // Total de registros
                    [
                        'users' => $users, // Envía el objeto Paginator completo (contiene data, current_page, last_page, etc.)
                        'available_roles' => $companyRoles, // <-- ¡NUEVA VARIABLE!
                    ]
                )
            );
        } catch (\Exception $e) {
            // Manejo de errores
            Log::error("Error al listar usuarios: " . $e->getMessage());
            return response()->json(
                $this->eMessageError('Error al procesar la solicitud. Detalles: ' . $e->getMessage(), 'Error interno del servidor'),
                500
            );
        }
    }












    /**
     * @OA\Put(
     *     path="/api/admin/users/{userId}/permissions",
     *     summary="Actualizar permisos individuales de un usuario",
     *     tags={"Gestión de Usuarios Administración"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="ID del usuario al que se le actualizarán los permisos",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="give_permissions",
     *                     type="array",
     *                     description="Lista de permisos a asignar al usuario",
     *                     @OA\Items(type="string", example="editar usuarios")
     *                 ),
     *                 @OA\Property(
     *                     property="revoke_permissions",
     *                     type="array",
     *                     description="Lista de permisos a revocar del usuario",
     *                     @OA\Items(type="string", example="crear usuarios")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Permisos actualizados correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Permisos del usuario actualizados correctamente"),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 description="Datos del usuario actualizado"
     *             ),
     *             @OA\Property(
     *                 property="permissions",
     *                 type="array",
     *                 description="Permisos activos del usuario después de la actualización",
     *                 @OA\Items(type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No tiene permisos para modificar permisos")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Usuario no encontrado o no pertenece a esta empresa")
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
    public function updateUserPermissions(Request $request, $userId)
    {

        try {

            $admin = auth()->user();
            $user = User::where('id', $userId)
                ->where('company_id', $admin->company_id)
                ->first();

            if (!$user) {
                return response()->json($this->notFound(), 404);
            }

            // Validación
            $validator = Validator::make($request->all(), [
                'give_permissions' => 'nullable|array',
                'give_permissions.*' => 'string',
                'revoke_permissions' => 'nullable|array',
                'revoke_permissions.*' => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json($this->validationError($validator->errors()), status: 422);
            }

            // Ver si el usuario tiene rol
            $role = $user->roles()->first();

            // Dar permisos
            if ($request->filled('give_permissions')) {
                foreach ($request->give_permissions as $permName) {

                    $permission = Permission::firstOrCreate([
                        'name' => $permName,
                        'company_id' => $admin->company_id,
                        'guard_name' => 'api'
                    ]);

                    // 🔥 Se asignan solo al usuario — NO AL ROL
                    $user->givePermissionTo($permission->name);
                }
            }

            // Revocar permisos
            if ($request->filled('revoke_permissions')) {
                foreach ($request->revoke_permissions as $permName) {

                    if ($user->hasPermissionTo($permName)) {
                        // 🔥 Solo revoca para este usuario
                        $user->revokePermissionTo($permName);
                    }
                }
            }

            return response()->json($this->successfullMessage(201, 'Permisos actualizados correctamente', true, $user->count(), ['permissions' => $user->getAllPermissions()->pluck('name')]));


        } catch (\Exception $e) {
            Log::info("Error exception./" . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error exception'), 500);
        }
    }



    /**
     * @OA\Post(
     *     path="/api/admin/companies/{companyId}/roles",
     *     summary="Crear un nuevo rol y asignar permisos para una empresa específica",
     *     tags={"Gestión de Usuarios Administración"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="companyId",
     *         in="path",
     *         required=true,
     *         description="ID de la empresa donde se creará el rol",
     *         @OA\Schema(type="integer", example=37)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"role_name"},
     *                 @OA\Property(
     *                     property="role_name",
     *                     type="string",
     *                     example="Vendedor Externo",
     *                     description="Nombre del rol que se va a crear"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="Rol para vendedores que atienden clientes externos",
     *                     description="Descripción opcional del rol"
     *                 ),
     *                 @OA\Property(
     *                     property="permissions",
     *                     type="array",
     *                     @OA\Items(type="string"),
     *                     example={"ver productos", "crear pedidos"},
     *                     description="Lista de permisos que se asignarán al rol (opcional)"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Rol creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Rol creado exitosamente para la empresa"),
     *             @OA\Property(property="role", type="object"),
     *             @OA\Property(property="permissions", type="array", @OA\Items(type="string"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No tiene permisos para crear roles")
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
    public function addRoleToCompany(Request $request, $companyId)
    {

        try {
            $admin = auth()->user();

            // Solo admin general puede crear roles
            if ($admin->role_id !== null) {
                //return response()->json(['error' => 'No tiene permisos para crear roles'], 403);
                return response()->json($this->unauthorized('No tiene permisos para crear roles'), status: 403);

            }

            // Validación
            $validator = Validator::make($request->all(), [
                'role_name' => 'required|string|max:255',
                'description' => 'nullable|string|max:500',
                'permissions' => 'nullable|array',
                'permissions.*' => 'string'
            ]);

            if ($validator->fails()) {
                //return response()->json($validator->errors(), 422);
                return response()->json($this->validationError($validator->errors()), status: 422);

            }

            // Crear rol para la empresa
            $role = Role::firstOrCreate(
                [
                    'name' => $request->role_name,
                    'company_id' => $companyId,
                    'guard_name' => 'api'
                ],
                [
                    'description' => $request->description ?? ''
                ]
            );

            // Asignar permisos si existen
            if ($request->filled('permissions')) {
                $perms = [];
                foreach ($request->permissions as $permName) {
                    $perms[] = Permission::firstOrCreate([
                        'name' => $permName,
                        'company_id' => $companyId,
                        'guard_name' => 'api'
                    ])->name;
                }
                $role->syncPermissions($perms);
            }

            /*return response()->json([
                'message' => 'Rol creado exitosamente para la empresa',
                'role' => $role,
                'permissions' => $role->permissions->pluck('name')
            ], 201);*/

            return response()->json($this->successfullMessage(201, 'Rol creado exitosamente para la empresa', true, $role->count(), ['permissions' => $role->permissions->pluck('name')]));


        } catch (\Exception $e) {
            Log::info("Error exception ./" . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error exception'), 500);
        }
    }



}
