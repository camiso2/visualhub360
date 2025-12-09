<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth; //

use App\Models\User;
use App\Models\Company;
use App\Models\Branch;
use App\Models\Sale;
use App\Services\RolePermissionService;
use Illuminate\Support\Str;

use Spatie\Permission\Models\Role;
use App\Custom\GeneratesInvoiceNumber;

use App\Custom\ApiResponseTrait;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Authentication endpoints"
 * )
 */
class AuthController extends Controller
{

    use ApiResponseTrait, GeneratesInvoiceNumber;
    /**
     * @OA\Post(
     * path="/api/registerCompany",
     * summary="Registrar un nuevo usuario, su empresa y la sucursal principal",
     * tags={"Registro Empresa"},
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     * mediaType="multipart/form-data",
     * @OA\Schema(
     * required={"user[name]","user[email]","user[phone]","user[address]","user[city]","user[department]","user[document_type]","user[document_number]","user[password]","company[name]","company[email]"},
     * @OA\Property(
     * property="user[avatar]",
     * type="string",
     * format="binary",
     * description="Archivo de imagen del avatar"
     * ),
     * @OA\Property(property="user[name]", type="string", example="Jaiver Ocampo"),
     * @OA\Property(property="user[email]", type="string", format="email", example="jaiver@example.com"),
     * @OA\Property(property="user[phone]", type="string", example="3174885954"),
     * @OA\Property(property="user[address]", type="string", example="calle 15 cll 8 # 45-67"),
     * @OA\Property(property="user[city]", type="string", example="Armenia"),
     * @OA\Property(property="user[department]", type="string", example="Quindío"),
     * @OA\Property(property="user[document_type]", type="string", example="CC"),
     * @OA\Property(property="user[document_number]", type="string", example="41944785"),
     * @OA\Property(property="user[password]", type="string", format="password", example="12345678"),
     * @OA\Property(property="company[name]", type="string", example="Visionhub360 S.A."),
     * @OA\Property(property="company[legal_name]", type="string", example="Visionhub360 Sociedad Anónima"),
     * @OA\Property(property="company[document_type]", type="string", example="NIT"),
     * @OA\Property(property="company[document_number]", type="string", example="123456789"),
     * @OA\Property(property="company[dv]", type="string", example="1"),
     * @OA\Property(property="company[email]", type="string", format="email", example="contacto@Visionhub360.com"),
     * @OA\Property(property="company[phone]", type="string", example="+57 123 456 7890"),
     * @OA\Property(property="company[website]", type="string", example="https://Visionhub360.com"),
     * @OA\Property(property="company[address]", type="string", example="Calle Falsa 123"),
     * @OA\Property(property="company[neighborhood]", type="string", example="Centro"),
     * @OA\Property(property="company[city]", type="string", example="Bogotá"),
     * @OA\Property(property="company[department]", type="string", example="Cundinamarca"),
     * @OA\Property(property="company[country]", type="string", example="Colombia"),
     * @OA\Property(property="company[tax_regime]", type="string", example="General"),
     * @OA\Property(property="company[economic_activity_code]", type="string", example="3320"),
     * @OA\Property(property="company[billing_resolution]", type="string", example="001-001"),
     * @OA\Property(property="company[billing_resolution_date]", type="string", format="date", example="2025-01-01"),
     * @OA\Property(property="company[is_verified]", type="boolean", example=true),
     * @OA\Property(property="company[active]", type="boolean", example=true),
     * @OA\Property(
     * property="company[logo_path]",
     * type="string",
     * format="binary",
     * description="Archivo de imagen del logo"
     * ),
     * @OA\Property(property="company[color_theme]", type="string", example="#FF5733"),
     * @OA\Property(property="company[verified_at]", type="string", format="date-time", example="2025-01-01T12:00:00"),
     * @OA\Property(
     * property="branch[name]",
     * type="string",
     * example="Oficina Central",
     * description="Nombre de la Sucursal Principal. Opcional, si no se envía se usará un nombre por defecto."
     * ),
     * @OA\Property(
     * property="branch[phone]",
     * type="string",
     * example="+57 321 987 6543",
     * description="Teléfono de contacto de la sucursal."
     * ),
     * @OA\Property(
     * property="branch[email]",
     * type="string",
     * format="email",
     * example="principal@Visionhub360.com",
     * description="Email de contacto de la sucursal."
     * ),
     * @OA\Property(
     * property="branch[image]",
     * type="string",
     * format="binary",
     * description="Imagen opcional de la sucursal."
     * ),
     * @OA\Property(
     * property="branch[address]",
     * type="string",
     * example="Calle Principal 456",
     * description="Dirección física de la sucursal."
     * ),
     * @OA\Property(
     * property="branch[city]",
     * type="string",
     * example="Bogotá",
     * description="Ciudad de la sucursal."
     * ),
     * @OA\Property(
     * property="branch[department]",
     * type="string",
     * example="Cundinamarca",
     * description="Departamento de la sucursal."
     * ),
     * @OA\Property(
     * property="branch[active]",
     * type="boolean",
     * example=true,
     * description="Estado de la sucursal (activa/inactiva)."
     * )
     * )
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Usuario, empresa y sucursal registrados correctamente",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Usuario, empresa y sucursal registrados correctamente"),
     * @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
     * @OA\Property(property="user", type="object"),
     * @OA\Property(property="company", type="object"),
     * @OA\Property(property="branch", type="object", description="Datos de la sucursal principal creada.")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Error de validación",
     * @OA\JsonContent(
     * @OA\Property(property="errors", type="object")
     * )
     * )
     * )
     */

    public function registerCompany(Request $request)
    {
        try {
            // 1. Pre-procesamiento de datos booleanos para Company y Branch
            $companyData = $request->input('company', []);
            $companyData['is_verified'] = filter_var($request->input('company.is_verified'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false;
            $companyData['active'] = filter_var($request->input('company.active'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? true;
            $request->merge(['company' => $companyData]);

            $branchData = $request->input('branch', []);
            $branchData['active'] = filter_var($request->input('branch.active'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? true;
            $request->merge(['branch' => $branchData]);


            // 2. 🔹 Validación de campos
            $validator = Validator::make($request->all(), [
                // Reglas de Usuario (User)
                'user.avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'user.name' => 'required|string|max:255',
                'user.email' => 'required|email|unique:users,email',
                'user.phone' => 'required|string|min:8',
                'user.address' => 'required|string|min:8|max:80',
                'user.city' => 'required|string|min:3|max:50',
                'user.department' => 'required|string|min:3|max:50',
                'user.document_type' => 'required|string|min:1|max:12',
                'user.document_number' => 'required|string|min:7|max:12|unique:users,document_number', // Asumiendo que el DNI/CC es único
                'user.password' => 'required|string|min:6',

                // Reglas de Empresa (Company)
                'company.name' => 'required|string|max:255',
                'company.legal_name' => 'required|string|max:255',
                'company.document_type' => 'required|string',
                'company.document_number' => 'required|string|unique:companies,document_number', // Asumiendo que el NIT es único
                'company.dv' => 'nullable|string',
                'company.email' => 'required|email|unique:companies,email', // Asumiendo que el email de la empresa es único
                'company.phone' => 'nullable|string',
                'company.website' => 'nullable|url', // Se cambia a url para mayor validación
                'company.address' => 'nullable|string',
                'company.neighborhood' => 'nullable|string',
                'company.city' => 'nullable|string',
                'company.department' => 'nullable|string',
                'company.country' => 'nullable|string',
                'company.tax_regime' => 'nullable|string',
                'company.economic_activity_code' => 'nullable|string',
                'company.billing_resolution' => 'nullable|string',
                'company.billing_resolution_date' => 'nullable|date',
                'company.is_verified' => 'nullable|boolean',
                'company.active' => 'nullable|boolean',
                'company.logo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'company.color_theme' => 'nullable|string',
                'company.verified_at' => 'nullable|date',

                // Reglas de Sucursal (Branch) - NUEVAS REGLAS
                // El campo branch.name es opcional según el Swagger, si no se envía, se usará el nombre por defecto
                'branch.name' => 'nullable|string|max:255',
                'branch.phone' => 'nullable|string|max:20',
                'branch.email' => [
                    'nullable',
                    'email',
                    'max:255',
                    // No se valida unicidad del email de sucursal aquí, se puede validar en una etapa posterior si es necesario

                ],
                'branch.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'branch.address' => 'nullable|string|max:255',
                'branch.city' => 'nullable|string|max:50',
                'branch.department' => 'nullable|string|max:50',
                'branch.active' => 'nullable|boolean'
            ]);

            if ($validator->fails()) {
                return response()->json($this->validationError($validator->errors()), 422);
            }

            // 3. 🔹 Manejo de subida de archivos

            // Subir logo de la empresa
            if ($request->hasFile('company.logo_path')) {
                $file = $request->file('company.logo_path');
                $filename = 'logo_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('logos'), $filename);
                $companyData['logo_path'] = '/logos/' . $filename;
            } else {
                $companyData['logo_path'] = null;
            }

            // Subir avatar del usuario
            $userAvatarPath = null;
            if ($request->hasFile('user.avatar')) {
                $file = $request->file('user.avatar');
                $filename = 'avatar_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('avatars'), $filename);
                $userAvatarPath = '/avatars/' . $filename;
            }

            // Subir imagen de la sucursal
            $branchImagePath = null;
            if ($request->hasFile('branch.image')) {
                $file = $request->file('branch.image');
                $filename = 'branch_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('branches'), $filename);
                $branchImagePath = '/branches/' . $filename;
            }

            // 4. 🔹 Crear empresa
            $company = Company::create($companyData);

            // 5. 🔹 Inicializar roles y permisos (Asumiendo que RolePermissionService existe)
            $roleService = new RolePermissionService();
            $roleService->initializeForCompany($company);

            // 6. 🔹 Crear sucursal principal
            $defaultBranchName = $branchData['name'] ?? 'Sucursal Principal - ' . $company->name;

            // Generar código único para la sucursal
            do {
                $code = strtoupper(Str::random(6));
            } while (Branch::where('code', $code)->exists());

            $branch = Branch::create([
                'company_id' => $company->id,
                'name' => $defaultBranchName,
                'code' => $code,
                'phone' => $branchData['phone'] ?? null,
                'email' => $branchData['email'] ?? null,
                'image' => $branchImagePath,
                'address' => $branchData['address'] ?? $company->address, // Usa dirección de la empresa como fallback
                'city' => $branchData['city'] ?? $company->city, // Usa ciudad de la empresa como fallback
                'department' => $branchData['department'] ?? $company->department, // Usa departamento de la empresa como fallback
                'active' => $branchData['active'],
            ]);

            // 7. 🔹 Crear usuario asociado a la empresa y sucursal
            $userData = $request->input('user');

            // Encontrar el rol de Administrador General
            $adminRole = Role::where('name', 'Administrador General')
                ->where('company_id', $company->id)
                ->first();

            $user = User::create([
                'avatar' => $userAvatarPath,
                'name' => $userData['name'],
                'email' => $userData['email'],
                'phone' => $userData['phone'],
                'address' => $userData['address'],
                'city' => $userData['city'],
                'department' => $userData['department'],
                'document_type' => $userData['document_type'],
                'document_number' => $userData['document_number'],
                'password' => Hash::make($userData['password']),
                'company_id' => $company->id/*$company->id*/ ,
                'branch_id' => $branch->id, // Asignar al usuario la sucursal principal
                'role_id' => $adminRole->id ?? null, // Asignar el ID del rol de Administrador General
            ]);

            // 🚀 Asignar el rol oficialmente a través de Spatie
            if ($adminRole) {
                $user->assignRole($adminRole->name);
            }

            // 8. 🔹 Generar token JWT
            $token = auth('api')->login($user);

            // 9. 🔹 Respuesta exitosa
            return response()->json($this->successfullMessage(
                201,
                'Usuario, empresa y sucursal registrados correctamente',
                true,
                1,
                [
                    'token' => $token,
                    'user' => $user,
                    'company' => $company,
                    'branch' => $branch, // Incluir la sucursal en la respuesta
                ]
            ), 201);


        } catch (\Exception $e) {
            Log::info("Error exception ./" . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error exception'), 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Iniciar sesión y obtener JWT con información de la empresa y sucursal",
     *     tags={"Autenticación"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password","branch_code"},
     *             @OA\Property(property="email", type="string", format="email", example="jaiver@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678"),
     *             @OA\Property(property="branch_code", type="string", example="A1B2C3", description="Código de la sucursal donde inicia sesión")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
     *             @OA\Property(property="user", type="object"),
     *             @OA\Property(property="company", type="object"),
     *             @OA\Property(property="branch", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales inválidas",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Correo o contraseña incorrectos")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Empresa inactiva",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="La empresa asociada no está activa")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sucursal no encontrada o no pertenece a la empresa",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Sucursal no encontrada o no pertenece a su empresa")
     *         )
     *     )
     * )
     */
    // app/Http/Controllers/AuthController.php
    /*public function login(Request $request)
{
    // Log::info('Login request received:', $request->all()); // Descomenta solo para depuración

    try {
        // 1. Validar solo credenciales básicas
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'branch_code' => 'nullable|string', // Se mantiene la validación para uso futuro
        ]);

        // 2. Obtener el usuario SIN CARGAR RELACIONES PESADAS
        $user = User::where('email', $request->email)->first();

        // 3. Validar credenciales
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json($this->errorGeneric('Correo o contraseña incorrectos', 401), 401);
        }

        // 4. Cargar SOLO la compañía AHORA para verificar el estado de ACTIVO
        // (Esto es necesario si la verificación de activo es un requisito de login)
        $user->load('company');

        // 5. Validar que la empresa esté activa
        if (!$user->company || !$user->company->active) {
            return response()->json($this->errorGeneric('La empresa asociada no está activa', 403), 403);
        }

        // 6. Generar el token INMEDIATAMENTE
        // (La lógica de sucursal se simplifica o se mueve al middleware/me())
        $token = auth('api')->login($user);

        // 7. Determinar Bandera de Configuración (cargando las sucursales solo para el count)
        $hasBranches = $user->company->branches()->exists();
        $needsBranchSetup = !$hasBranches;

        // 8. Respuesta: Solo TOKEN y datos mínimos
        // NOTA: El frontend debe llamar inmediatamente a /api/me para obtener 'user' y 'permissions'.
        return response()->json($this->successfullMessage(
            200,
            $needsBranchSetup ? 'Configuración de sucursal pendiente' : 'Usuario inició sesión correctamente',
            true,
            $user->company->branches()->count(), // Se mantiene el count si es necesario para el frontend
            [
                'token' => $token,
                // Solo enviamos datos MÍNIMOS, no relaciones pesadas.
                'user_id' => $user->id,
                'email' => $user->email,
                'needs_branch_setup' => $needsBranchSetup,

                // NOTA: La sucursal activa se maneja mejor en el JWT Claim o en el /me.
                // Si necesitas el objeto 'branch' en el login, cárgalo aquí, pero es menos ideal.
            ]
        ), 200);

    } catch (\Exception $e) {
        Log::error("Error en login: " . $e->getMessage());
        return response()->json($this->eMessageError($e->getMessage(), 'Error exception'), 500);
    }
}*/

    public function login(Request $request)
    {
        // Corregimos la sintaxis de Log::info (Array to string conversion)
        //Log::info('Login request received:', $request->all());

        try {
            // 1. Validar SOLO email y password primero
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
                'branch_code' => 'nullable|string',
            ]);

            $user = User::with('company', /*'roles.permissions',*/ 'branch')->where('email', $request->email)->first();

            // 2. Validar credenciales
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json($this->errorGeneric('Correo o contraseña incorrectos', 401), 401);
            }

            // 3. Validar que la empresa esté activa
            if (!$user->company || !$user->company->active) {
                return response()->json($this->errorGeneric('La empresa asociada no está activa', 403), 403);
            }

            // 4. Determinar Sucursal y Generar Bandera
            $branch = null;
            // Asume que 'branches()' devuelve una colección con sucursales
            $hasBranches = $user->company->branches()->exists();

            $needsBranchSetup = !$hasBranches; // Bandera: true si NO tiene sucursales

            if ($hasBranches) {
                // A. Flujo Normal: La empresa tiene sucursales
                if ($request->filled('branch_code')) {
                    // Buscar sucursal por código
                    $branch = $user->company->branches()->where('code', $request->branch_code)->first();

                    if (!$branch) {
                        return response()->json($this->errorGeneric('Sucursal no encontrada o código inválido', 404), 404);
                    }
                } else {
                    // Si no se envía código, tomar la primera sucursal (o la lógica por defecto)
                    $branch = $user->company->branches()->first();
                    // Aquí podrías forzar que el usuario SIEMPRE envíe un branch_code si hay múltiples sucursales
                }
            }

            // 5. Asignar branch_id (solo si se encontró una sucursal)
            // Si $branch es null, $user->branch_id será null. El JWT contendrá 'active_branch_id': null
            $user->branch_id = $branch ? $branch->id : null;



            $user->save();



            // 6. Generar el token (se genera sin importar si hay sucursal)
            $token = auth('api')->login($user);

            // 7. Respuesta con la bandera de configuración
            return response()->json($this->successfullMessage(
                200,
                $needsBranchSetup ? 'Configuración de sucursal pendiente' : 'Usuario inició sesión correctamente',
                true,
                $user->company->branches()->count(),
                [
                    'token' => $token,
                    'user' => $user,
                    //'company' => $user->company,
                    'branch' => $branch, // Será null si needsBranchSetup es true
                    'needs_branch_setup' => $needsBranchSetup, // Bandera de configuración
                    'last_invoice_number' => $this->getNextInvoiceNumber($user),

                ]
            ), 200);

        } catch (\Exception $e) {
            Log::error("Error en login: " . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error exception'), 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Cerrar sesión de usuario",
     *     tags={"Autenticación"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Sesión terminada con éxito")
     * )
     */
    public function logout()
    {
        try {
            auth()->logout();

            // return response()->json(['message' => 'Sesión cerrada con éxito']);
            return response()->json($this->successfullMessage(
                201,
                'Sesión cerrada con éxito',
                true,
                1,
                []
            ), 201);

        } catch (\Exception $e) {
            Log::info("Error exception ./" . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error exception'), 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/refresh",
     *     summary="Refrescar JWT token",
     *     tags={"Autenticación"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Token refrescado con éxito")
     * )
     */
    public function refresh()
    {

        /* return response()->json([
            'token' => auth()->refresh(),
            'user' => auth()->user(),
            'company' => auth()->user()->company
        ]);*/
        try {
            return response()->json($this->successfullMessage(
                201,
                'Sesión refrescada con éxito',
                true,
                1,
                [
                    'token' => auth()->refresh(),
                    'user' => auth()->user(),
                    'company' => auth()->user()->company
                ]
            ), 201);
        } catch (\Exception $e) {
            Log::info("Error exception ./" . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error exception'), 500);
        }

    }

    /**
     * @OA\Get(
     *     path="/api/me",
     *     summary="Get autenticación de usuario",
     *     tags={"Autenticación"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Información de Usuario Autenticado")
     * )
     */
    public function me()
    {
        try {
            $userId = auth()->id();

            if (!$userId) {
                return response()->json($this->errorGeneric('Sesión no encontrada', 401), 401);
            }

            // 1. CARGAR EL USUARIO con las relaciones base.
            $user = User::with([
                'company',
                'branch',
                // Cargar 'roles' para que getAllPermissions funcione correctamente.
                'roles'
            ])
                ->where('id', $userId)
                ->first();

            if (!$user) {
                return response()->json($this->errorGeneric('Usuario autenticado no encontrado', 401), 401);
            }

            // 2. OBTENER TODOS LOS PERMISOS (Directos + Heredados)
            $allPermissions = $user->getAllPermissions();

            // 🛑 CRÍTICO: SOBREESCRIBIR la clave 'permissions' con la lista unificada.
            // Esto asegura que el frontend vea la lista completa bajo el nombre esperado.
            $user->setRelation('permissions', $allPermissions);

            // Opcional: Si quieres eliminar la clave 'roles' para simplificar el JSON, puedes hacerlo aquí.
            // $user->setRelation('roles', collect()); // Si solo quieres la lista plana de permisos.

            // 3. RECUPERAR DATOS CLAVE
            $branch = $user->branch;
            $hasBranches = $user->company->branches()->exists();
            $needsBranchSetup = !$hasBranches;

            // 4. PREPARAR RESPUESTA FINAL
            // Convertimos a array para incluir las relaciones modificadas.




            $userData = $user->toArray();


            return response()->json($this->successfullMessage(
                200,
                $needsBranchSetup ? 'Configuración de sucursal pendiente' : 'Sesión obtenida con éxito',
                true,
                $user->company->branches()->count(),
                [
                    'user' => $userData, // Ahora 'user.permissions' contiene TODO.
                    'branch' => $branch,
                    'needs_branch_setup' => $needsBranchSetup,
                    'last_invoice_number' => $this->getNextInvoiceNumber($user),

                ]
            ), 200);

        } catch (\Exception $e) {
            Log::info("Error exception ./" . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error exception'), 500);
        }
    }

}
