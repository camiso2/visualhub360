<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Custom\ApiResponseTrait;
use Illuminate\Support\Facades\Log;


class ClientController extends Controller
{
    use ApiResponseTrait;
    /**
     * @OA\Post(
     *     path="/api/regiterClient",
     *     summary="Registrar un nuevo cliente",
     *     tags={"Gestión de Clientes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos del cliente a registrar (con opción de imagen)",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name", "document_type", "document_number"},
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john@example.com"),
     *                 @OA\Property(property="phone", type="string", example="3001234567"),
     *                 @OA\Property(property="document_type", type="string", example="CC"),
     *                 @OA\Property(property="document_number", type="string", example="123456789"),
     *                 @OA\Property(property="address", type="string", example="Calle 123 #45-67"),
     *                 @OA\Property(property="city", type="string", example="Bogotá"),
     *                 @OA\Property(property="department", type="string", example="Cundinamarca"),
     *                 @OA\Property(property="active", type="boolean", example=true),
     *                 @OA\Property(
     *                     property="branch_code",
     *                     type="string",
     *                     example="A1B2C3",
     *                     description="Código de la sucursal donde se registra el cliente (opcional, si se omite se asigna la primera sucursal)"
     *                 ),
     *                 @OA\Property(
     *                     property="avatar",
     *                     type="string",
     *                     format="binary",
     *                     description="Imagen o foto del cliente (opcional)"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cliente registrado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente registrado correctamente"),
     *             @OA\Property(property="client", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No autorizado para registrar clientes"
     *     )
     * )
     */
    public function regiterClient(Request $request)
    {
        try {
            if ($request->has('active')) {
                $request->merge([
                    'active' => filter_var($request->active, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
                ]);
            }

            $autUser = auth()->user();

            if (!$autUser || !$autUser->company_id) {
                return response()->json($this->unauthorized('No se encontró empresa asociada al usuario'));
            }

            $companyId = $autUser->company_id;

            // Determinar la sucursal
            if ($request->filled('branch_code')) {
                $branch = Branch::where('company_id', $companyId)
                    ->where('code', $request->branch_code)
                    ->first();

                if (!$branch) {
                    return response()->json($this->errorGeneric('Sucursal no encontrada para esta empresa', 404), 404);
                }
            } else {
                $branch = Branch::where('company_id', $companyId)->first();

                if (!$branch) {
                    return response()->json($this->errorGeneric('No hay sucursales asociadas a la empresa', 404), 404);
                }
            }

            Log::info('que valores :: ', $request->all());

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => [
                    'nullable',
                    'email',
                    'max:255',
                    Rule::unique('clients')->where(fn($query) => $query->where('company_id', $companyId)),
                ],
                'phone' => 'nullable|string|max:20',
                'document_type' => 'required|string|max:10',
                'document_number' => [
                    'required',
                    Rule::unique('clients')->where(fn($query) => $query->where('company_id', $companyId)),
                ],
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'department' => 'nullable|string|max:100',
                'active' => 'boolean',
                'branch_code' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                //return response()->json($this->validationError($validator->errors()), 422);

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

            // Crear cliente y guardar el branch_id correspondiente
            $client = Client::create([
                'company_id' => $companyId,
                'branch_id' => $autUser->branch_id,
                'branch_code' => $autUser->code,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'document_type' => $request->document_type,
                'document_number' => $request->document_number,
                'address' => $request->address,
                'city' => $request->city,
                'department' => $request->department,
                'active' => $request->active ?? true,
            ]);

            return response()->json($this->successfullMessage(
                201,
                'Cliente registrado correctamente',
                true,
                1,
                ['client' => $client]
            ));

        } catch (\Exception $e) {
            Log::info("Error exception register client./" . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error al registrar cliente'), 500);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/clients/update/{id}",
     *     summary="Actualizar datos de un cliente",
     *     tags={"Gestión de Clientes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del cliente a actualizar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Campos del cliente a actualizar (branch_code y branch_id no se pueden editar)",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john@example.com"),
     *                 @OA\Property(property="phone", type="string", example="3001234567"),
     *                 @OA\Property(property="document_type", type="string", example="CC"),
     *                 @OA\Property(property="address", type="string", example="Calle 123 #45-67"),
     *                 @OA\Property(property="city", type="string", example="Bogotá"),
     *                 @OA\Property(property="department", type="string", example="Cundinamarca"),
     *                 @OA\Property(property="active", type="boolean", example=true),
     *                 @OA\Property(
     *                     property="avatar",
     *                     type="string",
     *                     format="binary",
     *                     description="Imagen o foto del cliente (opcional)"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente actualizado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente actualizado correctamente"),
     *             @OA\Property(property="client", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No autorizado para actualizar clientes"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado"
     *     )
     * )
     */


    public function updateClient(Request $request, $clientId)
    {
        try {
            $authUser = auth()->user();

            if (!$authUser || !$authUser->company_id) {
                return response()->json($this->unauthorized('No se encontró empresa asociada al usuario'), 403);
            }

            // Obtener cliente de la misma empresa
            $client = Client::where('company_id', $authUser->company_id)->find($clientId);

            if (!$client) {
                return response()->json($this->errorGeneric('Cliente no encontrado', 404), 404);
            }

            // Convertir 'active' a booleano si viene
            if ($request->has('active')) {
                $request->merge([
                    'active' => filter_var($request->active, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
                ]);
            }


            $input = $request->all();

            // Log para debug
            Log::info('Llegó a update client controller ::', $input);

            // Validación
            $validator = Validator::make($input, [
                'name' => 'sometimes|required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('clients')->ignore($clientId)->where(fn($query) => $query->where('company_id', $authUser->company_id)),
                ],
                'phone' => 'nullable|string|max:20',
                'document_type' => 'sometimes|required|string|max:10',
                /*'document_number' => [
                    'required',
                    Rule::unique('clients')->where(fn($query) => $query->where('company_id', $authUser->company_id)),
                ],*/
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

            // Actualizar solo los campos permitidos (branch_code y branch_id no se pueden editar)
            $fields = ['name', 'email', 'phone', 'document_type', /*'document_number',*/ 'address', 'city', 'department', 'active'];
            foreach ($fields as $field) {
                if (isset($input[$field])) {
                    $client->{$field} = $input[$field];
                }
            }

            $client->save();

            return response()->json($this->successfullMessage(
                200,
                'Cliente actualizado correctamente',
                true,
                1,
                ['client' => $client]
            ));

        } catch (\Exception $e) {
            Log::info("Error exception update client./" . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error al actualizar cliente'), 500);
        }
    }






    /**
     * @OA\Get(
     * path="/api/clients",
     * summary="Lista todos los clientes activos de la empresa con paginación",
     * tags={"Gestión de Clientes"},
     * security={{"bearerAuth":{}}},
     *
     * @OA\Parameter(
     * name="per_page",
     * in="query",
     * description="Número de clientes por página. Por defecto es 10.",
     * required=false,
     * @OA\Schema(
     * type="integer",
     * default=10
     * )
     * ),
     * @OA\Parameter(
     * name="page",
     * in="query",
     * description="Número de página a recuperar.",
     * required=false,
     * @OA\Schema(
     * type="integer",
     * default=1
     * )
     * ),
     *
     * @OA\Response(
     * response=201,
     * description="Lista de clientes con metadatos de paginación",
     * @OA\JsonContent(
     * @OA\Property(property="success", type="boolean", example=true),
     * @OA\Property(property="code", type="integer", example=201),
     * @OA\Property(property="message", type="string", example="Lista de clientes empresa"),
     * @OA\Property(property="total_items", type="integer", example=50, description="Conteo total de registros en todas las páginas."),
     * @OA\Property(
     * property="data",
     * type="object",
     * @OA\Property(
     * property="clients",
     * type="object",
     * description="Objeto de paginación de Laravel",
     * @OA\Property(property="current_page", type="integer", example=1),
     * @OA\Property(
     * property="data",
     * type="array",
     * @OA\Items(
     * type="object",
     * description="Detalle del objeto Cliente",
     * @OA\Property(property="id", type="integer", example=1),
     * @OA\Property(property="name", type="string", example="Cliente Ejemplo S.A."),
     * @OA\Property(property="document_number", type="string", example="1234567890"),
     * @OA\Property(property="branch", type="object", description="Relación de la sucursal"),
     * )
     * ),
     * @OA\Property(property="first_page_url", type="string", example=".../api/clients?page=1"),
     * @OA\Property(property="from", type="integer", example=1),
     * @OA\Property(property="last_page", type="integer", example=5),
     * @OA\Property(property="last_page_url", type="string", example=".../api/clients?page=5"),
     * @OA\Property(property="next_page_url", type="string", nullable=true, example=".../api/clients?page=2"),
     * @OA\Property(property="path", type="string", example=".../api/clients"),
     * @OA\Property(property="per_page", type="integer", example=10),
     * @OA\Property(property="prev_page_url", type="string", nullable=true, example=null),
     * @OA\Property(property="to", type="integer", example=10),
     * @OA\Property(property="total", type="integer", example=50)
     * )
     * )
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Error interno del servidor"
     * )
     * )
     */
    public function index(Request $request)
    {
        // 1. Definir Paginación: Obtener el número de elementos por página, por defecto 10
        $perPage = $request->get('per_page', 10);
        // 🎯 Capturar el término de búsqueda
        $search = $request->get('search');

        try {
            $admin = auth()->user();

            // 2. Consulta Base
            $query = Client::query();

            // 3. Cargar Relaciones (Eager Loading)
            $query->with('branch');

            // 4. Implementar filtrado por compañía si es necesario (mantener como estaba)
            /*
            if ($admin) {
                 $query->where('company_id', $admin->company_id);
            }
            */

            // =========================================================
            // 🎯 5. LÓGICA DE BÚSQUEDA EN MÚLTIPLES CRITERIOS
            // =========================================================
            if ($search) {
                $query->where(function ($q) use ($search) {
                    // Se usa 'LIKE' con comodines (%) para búsqueda parcial y case-insensitive
                    $searchTerm = '%' . $search . '%';

                    $q->where('name', 'LIKE', $searchTerm)
                        ->orWhere('document_number', 'LIKE', $searchTerm)
                        ->orWhere('email', 'LIKE', $searchTerm)
                        ->orWhere('phone', 'LIKE', $searchTerm)
                        ->orWhere('address', 'LIKE', $searchTerm)
                        ->orWhere('city', 'LIKE', $searchTerm)// Opcional: buscar también en dirección
                        ->orWhere('department', 'LIKE', $searchTerm)// Opcional: buscar también en dirección
                        ->orWhere('created_at', 'LIKE', $searchTerm); // Opcional: buscar también en dirección
                });
            }
            // =========================================================

            // 6. Ordenar (Por la más reciente)
            $query->orderBy('created_at', 'desc');

            // 7. Ejecutar la consulta con Paginación
            $clients = $query->paginate($perPage);

            // 8. Respuesta Exitosa: Se usa el método total() del objeto Paginator para el conteo
            return response()->json($this->successfullMessage(
                201,
                'Lista de clientes empresa',
                true,
                $clients->total(), // total() devuelve el conteo total de items en todas las páginas
                ['clients' => $clients] // Se pasa el objeto Paginator completo
            ));

        } catch (\Exception $e) {
            // Manejo de errores
            Log::info("Error exception show clients./" . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error al mostrar cliente'), 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/clients/{id}",
     *     summary="Buscar cliente por ID",
     *     tags={"Gestión de Clientes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del cliente",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente encontrado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado"
     *     )
     * )
     */
    public function show($id)
    {

        try {
            $admin = auth()->user();

            $client = Client::where('id', $id)
                ->where('company_id', $admin->company_id)
                ->first();

            if (!$client) {
                return response()->json($this->notFound(), 404);
            }

            return response()->json($this->successfullMessage(201, 'Cliente encontrado', true, 1, ['client' => $client]));

        } catch (\Exception $e) {
            Log::info("Error exception show client./" . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error al mostrar cliente'), 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/clients/{id}",
     *     summary="Eliminar (soft delete) un cliente",
     *     tags={"Gestión de Clientes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del cliente",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente eliminado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {

        try {
            $admin = auth()->user();

            $client = Client::where('id', $id)
                ->where('company_id', $admin->company_id)
                ->first();

            if (!$client) {
                return response()->json($this->notFound(), 404);
            }

            $client->delete();

            return response()->json($this->successfullMessage(200, 'Cliente eliminado correctamente', true, 1, []));

        } catch (\Exception $e) {
            Log::info("Error exception delete client./" . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error al eliminar cliente'), 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/clients/trashed",
     *     summary="Listar clientes eliminados (soft deleted)",
     *     tags={"Gestión de Clientes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de clientes eliminados"
     *     )
     * )
     */
    public function trashed()
    {

        $admin = auth()->user();
        $clients = Client::onlyTrashed()->where('company_id', $admin->company_id)->get();

        return response()->json($clients);
    }

    /**
     * @OA\Post(
     *     path="/api/clients/{id}/restore",
     *     summary="Restaurar un cliente eliminado",
     *     tags={"Gestión de Clientes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del cliente a restaurar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente restaurado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado o no pertenece a la empresa"
     *     )
     * )
     */
    public function restore($id)
    {

        try {
            $admin = auth()->user();

            $client = Client::onlyTrashed()
                ->where('id', $id)
                ->where('company_id', $admin->company_id)
                ->first();

            if (!$client) {
                return response()->json($this->notFound(), 404);
            }

            $client->restore();

            return response()->json($this->successfullMessage(200, 'Cliente restaurado correctamente', true, 1, ['client' => $client]));
        } catch (\Exception $e) {
            Log::info("Error exception delete client./" . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error al restaurar cliente'), 500);
        }
    }



    /**
     * @OA\Post(
     *     path="/api/clients/searchByDocument",
     *     summary="Buscar un cliente por número de documento",
     *     tags={"Gestión de Clientes"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Número de documento del cliente a buscar",
     *         @OA\JsonContent(
     *             required={"document_number"},
     *             @OA\Property(
     *                 property="document_number",
     *                 type="string",
     *                 example="1234567890",
     *                 description="Número de documento del cliente"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Resultado de la búsqueda del cliente",
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="integer", example=201),
     *             @OA\Property(property="message", type="string", example="Cliente encontrado"),
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="count", type="integer", example=1),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="client",
     *                     type="object",
     *                     nullable=true,
     *                     description="Objeto del cliente encontrado",
     *                     @OA\Property(property="id", type="integer", example=25),
     *                     @OA\Property(property="name", type="string", example="Juan Pérez"),
     *                     @OA\Property(property="document_number", type="string", example="1234567890"),
     *                     @OA\Property(property="phone", type="string", example="3001234567")
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor"
     *     )
     * )
     */
    public function searchByDocument(Request $request)
    {
        try {
            $request->validate([
                'document_number' => 'required|string'
            ]);
            /* $companyId = auth()->user()->company_id;
             $client = Client::byCompany($companyId)
                 ->byDocumentNumber($request->document_number)
                 ->first();*/
            // Debido al Global Scope, ya NO es necesario filtrar por company_id
            /* $client = Client::byDocumentNumber($request->document_number)->first();
             $client = Client::with('documents')->get();*/
            $client = Client::byDocumentNumber($request->document_number)->first();
            if ($client) {
                $client->load('documents');
            }
            return response()->json(
                $this->successfullMessage(
                    201,
                    $client ? 'Cliente encontrado' : 'Cliente no encontrado',
                    (bool) $client,
                    $client ? 1 : 0,
                    ['client' => $client]
                ),
                201
            );
        } catch (\Exception $e) {
            Log::info("Error exception obtener client./" . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error al obtener cliente'), 500);
        }
    }



}
