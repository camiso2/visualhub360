<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Custom\ApiResponseTrait;
use App\Models\Supplier;

class SupplierController extends Controller
{

    use ApiResponseTrait;
    /**
     * @OA\Post(
     *     path="/api/admin/suppliers",
     *     summary="Registrar un nuevo proveedor",
     *     tags={"Gestión de Proveedores"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Joyas del Sur"),
     *             @OA\Property(property="document", type="string", example="12345678-9"),
     *             @OA\Property(property="email", type="string", example="contacto@gafasygafas.com"),
     *             @OA\Property(property="phone", type="string", example="98787 5656"),
     *             @OA\Property(property="address", type="string", example="Av. Central 456"),
     *             @OA\Property(property="city", type="string", example="Colombia"),
     *             @OA\Property(property="country", type="string", example="Bogotá")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Proveedor creado correctamente"
     *     )
     * )
     */
    public function createSupplier(Request $request)
    {

        try {
            $user = auth()->user();

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'document' => 'nullable|string|max:50|unique:suppliers,document', // <--- aquí
                'email' => 'nullable|email',
                'phone' => 'nullable|string|max:30',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'country' => 'nullable|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json($this->errorValidator($validator->errors()), 422);
            }

            $supplier = Supplier::create([
                'company_id' => $user->company_id,
                'name' => $request->name,
                'document' => $request->document,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'active' => true
            ]);
            return response()->json(
                $this->successfullMessage(
                    201,
                    'Proveedor creado correctamente',
                    true,
                    1,
                    ['supplier' => $supplier]
                )
            );


        } catch (\Exception $e) {
            Log::error("Error creating inventory: " . $e->getMessage());
            return response()->json($this->errorGeneric('Error al crear inventario: ' . $e->getMessage(), 500), 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/admin/suppliers/{supplier}",
     *     summary="Actualizar los datos de un proveedor existente",
     *     tags={"Gestión de Proveedores"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="supplier",
     *         in="path",
     *         required=true,
     *         description="ID del proveedor a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Joyas del Norte"),
     *             @OA\Property(property="document", type="string", example="98765432-1"),
     *             @OA\Property(property="email", type="string", example="contacto@joyasnorte.com"),
     *             @OA\Property(property="phone", type="string", example="320 987 6543"),
     *             @OA\Property(property="address", type="string", example="Cra 45 #22-18"),
     *             @OA\Property(property="city", type="string", example="Medellín"),
     *             @OA\Property(property="country", type="string", example="Colombia"),
     *             @OA\Property(property="active", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Proveedor actualizado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proveedor no encontrado"
     *     )
     * )
     */
    public function updateSupplier(Request $request, $supplierId)
    {
        try {
            $user = auth()->user();
            Log::info('valores que recibo :: ',$request->all() );

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                //'document' => 'nullable|string|max:50|unique:suppliers,document', // <--- aquí
                'email' => 'nullable|email',
                'phone' => 'nullable|string|max:30',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'country' => 'nullable|string|max:100',
                'active' => 'nullable|boolean'
            ]);

            if ($validator->fails()) {
                return response()->json($this->errorValidator($validator->errors()), 422);
            }

            $supplier = Supplier::where('company_id', $user->company_id)
                ->where('id', $supplierId)
                ->first();

            if (!$supplier) {
                return response()->json(
                    $this->errorGeneric('Proveedor no encontrado o no pertenece a su empresa', 404),
                    404
                );
            }

            $supplier->update([
                'name' => $request->name,
                'document' => $request->document,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'active' => $request->has('active') ? $request->active : $supplier->active,
            ]);

            return response()->json(
                $this->successfullMessage(
                    200,
                    'Proveedor actualizado correctamente',
                    true,
                    1,
                    ['supplier' => $supplier]
                )
            );

        } catch (\Exception $e) {
            Log::error("Error updating supplier: " . $e->getMessage());
            return response()->json($this->errorGeneric('Error al actualizar proveedor: ' . $e->getMessage(), 500), 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/admin/suppliers/{supplier}",
     *     summary="Eliminar un proveedor (soft delete)",
     *     tags={"Gestión de Proveedores"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="supplier",
     *         in="path",
     *         required=true,
     *         description="ID del proveedor a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Proveedor eliminado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proveedor no encontrado"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No tiene permisos para eliminar este proveedor"
     *     )
     * )
     */
    public function deleteSupplier($supplierId)
    {
        try {
            $user = auth()->user();

            if ($user->role_id !== null) {
                return response()->json(
                    $this->errorGeneric('No tiene permisos para eliminar provedores', 403),
                    403
                );
            }

            $supplier = Supplier::where('company_id', $user->company_id)
                ->where('id', $supplierId)
                ->first();

            if (!$supplier) {
                return response()->json(
                    $this->errorGeneric('Proveedor no encontrado o no pertenece a su empresa', 404),
                    404
                );
            }

            // Soft delete lógico: desactivar el proveedor
            $supplier->update(['active' => false]);

            return response()->json(
                $this->successfullMessage(
                    200,
                    'Proveedor eliminado correctamente',
                    true,
                    1,
                    ['supplier' => $supplier]
                )
            );

        } catch (\Exception $e) {
            Log::error("Error deleting supplier: " . $e->getMessage());
            return response()->json(
                $this->errorGeneric('Error al eliminar proveedor: ' . $e->getMessage(), 500),
                500
            );
        }
    }
    /**
     * @OA\Get(
     * path="/api/suppliers",
     * summary="Lista y busca proveedores con paginación",
     * tags={"Gestión de Proveedores"},
     * security={{"bearerAuth":{}}},
     *
     * @OA\Parameter(
     * name="per_page",
     * in="query",
     * description="Número de proveedores por página. Por defecto es 10.",
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
     * @OA\Parameter(
     * name="search",
     * in="query",
     * description="Término de búsqueda para filtrar por nombre, documento, email o teléfono.",
     * required=false,
     * @OA\Schema(
     * type="string"
     * )
     * ),
     *
     * @OA\Response(
     * response=201,
     * description="Lista de proveedores con metadatos de paginación",
     * @OA\JsonContent(
     * @OA\Property(property="success", type="boolean", example=true),
     * @OA\Property(property="code", type="integer", example=201),
     * @OA\Property(property="message", type="string", example="Lista de proveedores obtenida correctamente"),
     * @OA\Property(property="count", type="integer", example=30, description="Conteo total de registros en todas las páginas."),
     * @OA\Property(
     * property="data",
     * type="object",
     * @OA\Property(
     * property="suppliers",
     * type="object",
     * description="Objeto de paginación de Laravel",
     * @OA\Property(property="current_page", type="integer", example=1),
     * @OA\Property(
     * property="data",
     * type="array",
     * @OA\Items(
     * type="object",
     * description="Detalle del objeto Proveedor (ejemplo de campos)",
     * @OA\Property(property="id", type="integer", example=1),
     * @OA\Property(property="name", type="string", example="Proveedor Mayorista S.A."),
     * @OA\Property(property="document_number", type="string", example="900123456-7"),
     * @OA\Property(property="email", type="string", example="contacto@proveedor.com"),
     * @OA\Property(property="phone", type="string", example="6015551234"),
     * @OA\Property(property="created_at", type="string", format="date-time")
     * )
     * ),
     * @OA\Property(property="last_page", type="integer", example=3),
     * @OA\Property(property="per_page", type="integer", example=10),
     * @OA\Property(property="total", type="integer", example=30)
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

    public function listSuppliers(Request $request)
    {
        // 1. Definir Paginación: Obtener el número de elementos por página, por defecto 10
        $perPage = $request->get('per_page', 10);

        // 🎯 Capturar el término de búsqueda
        $search = $request->get('search');

        try {
            $user = auth()->user();

            // 2. Consulta Base
            // Solo obtenemos los proveedores de la misma empresa si el modelo tiene 'company_id'
            $query = Supplier::query();

            // 3. Filtrado por Empresa (Si aplica, asumiendo que el modelo Supplier tiene company_id)
            if ($user && property_exists($user, 'company_id')) {
                $query->where('company_id', $user->company_id);
            }

            // =========================================================
            // 🎯 4. LÓGICA DE BÚSQUEDA EN MÚLTIPLES CRITERIOS (Nombre, Documento, Email, Teléfono)
            // =========================================================
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $searchTerm = '%' . $search . '%';

                    $q->where('name', 'LIKE', $searchTerm)
                        ->orWhere('document', 'LIKE', $searchTerm)
                        ->orWhere('email', 'LIKE', $searchTerm)
                        ->orWhere('phone', 'LIKE', $searchTerm)
                        ->orWhere('name', 'LIKE', $searchTerm)
                        ->orWhere('address', 'LIKE', $searchTerm)
                        ->orWhere('city', 'LIKE', $searchTerm)
                        ->orWhere('country', 'LIKE', $searchTerm)
                        ->orWhere('created_at', 'LIKE', $searchTerm);
                });
            }
            // =========================================================

            // 5. Ordenar (Por la más reciente)
            $query->orderBy('created_at', 'desc');

            // 6. Ejecutar la consulta con Paginación
            $suppliers = $query->paginate($perPage);

            // 7. Respuesta Exitosa
            return response()->json(
                $this->successfullMessage(
                    201,
                    'Lista de proveedores obtenida correctamente',
                    true,
                    $suppliers->total(), // Usamos total() para el conteo global
                    ['suppliers' => $suppliers] // Se pasa el objeto Paginator completo
                ),
                201
            );

        } catch (\Exception $e) {
            // Manejo de errores
            Log::error("Error listing suppliers: " . $e->getMessage());
            return response()->json(
                $this->eMessageError('Error al obtener lista de proveedores: ' . $e->getMessage(), 500),
                500
            );
        }
    }



}
