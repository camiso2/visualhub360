<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Branch;
use App\Models\Inventory;
use App\Models\PaymentProvider; // Importación necesaria para la nueva lógica
use App\Models\AccountReceivable; // Importación necesaria para la nueva lógica
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Custom\ApiResponseTrait;
use Illuminate\Validation\Rule;
use App\Services\InvoicePdfService;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;



class SaleController extends Controller
{
    use ApiResponseTrait;

    protected $pdfService;

    public function __construct(InvoicePdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }



    /**
     * @OA\Post(
     * path="/api/sales",
     * summary="Registrar una nueva transacción de venta con pagos por ítem",
     * description="Registra una venta con la capacidad de asignar un método de pago y proveedor diferente a cada ítem.",
     * tags={"Gestión de Ventas"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * description="Datos requeridos para registrar la venta y sus ítems",
     * @OA\JsonContent(
     * required={"client_id", "items"},
     * @OA\Property(property="client_id", type="integer", example=42, description="ID del cliente al que se realiza la venta."),
     * @OA\Property(property="document_id", type="integer", example=1, nullable=true, description="ID del documento de cliente asociado a esta venta (Foreign Key)."),
     * @OA\Property(property="invoice_number", type="string", example="INV-2025-00123", nullable=true, description="Número de factura/recibo."),
     * @OA\Property(
     * property="items",
     * type="array",
     * description="Lista de productos vendidos, incluyendo el método de pago para cada uno.",
     * minItems=1,
     * @OA\Items(
     * required={"inventory_id", "quantity", "payment_method"},
     * @OA\Property(property="inventory_id", type="integer", example=15, description="ID del ítem de inventario."),
     * @OA\Property(property="quantity", type="integer", example=2, description="Cantidad vendida del ítem."),
     * @OA\Property(property="discount_percentage", type="number", format="float", example=5.00, description="Porcentaje de descuento a aplicar. Debe ser <= al max_disscount del inventario."),
     * @OA\Property(property="payment_method", type="string", example="Addi", description="Método de pago para este ítem (ej: efectivo, Transferencia, Addi)."),
     * @OA\Property(property="payment_provider_id", type="integer", example=30, nullable=true, description="ID del proveedor de pago (ej: Addi, Bancolombia). Obligatorio si el método NO es 'efectivo'."),
     * )
     * )
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Venta registrada correctamente y stock actualizado",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Venta registrada exitosamente"),
     * @OA\Property(property="sale", type="object", description="Objeto de la venta creada, incluyendo los ítems de detalle.")
     * )
     * ),
     * @OA\Response(
     * response=403,
     * description="Descuento o permisos no autorizados",
     * @OA\JsonContent(@OA\Property(property="message", type="string", example="El descuento solicitado (15.00%) para el producto 'Gafas de sol' excede el máximo permitido (10.00%)."))
     * ),
     * @OA\Response(
     * response=409,
     * description="Conflicto de stock",
     * @OA\JsonContent(@OA\Property(property="message", type="string", example="Stock insuficiente para el producto: Gafas de sol. Stock disponible: 1"))
     * ),
     * @OA\Response(
     * response=422,
     * description="Error de validación de datos"
     * ),
     * @OA\Response(
     * response=500,
     * description="Error interno del servidor (rollback de la transacción)"
     * )
     * )
     */
    public function createSale(Request $request)
    {


        $user = auth()->user();

        $branchId = $user->branch_id;

        // Validación
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'document_id' => 'nullable|exists:documents_clients,id',
            //'invoice_number' => 'required|nullable|string|unique:sales,invoice_number',
            'invoice_number' => [
                'required',
                'string',
                'nullable', // Aunque esté 'required', si el front envía null, esto ayuda, pero se suele omitir si ya es 'required'.
                Rule::unique('sales', 'invoice_number')->where(function ($query) use ($branchId) {
                    // Asegura que el número de factura solo se compare con otras ventas
                    // que tienen el mismo branch_id.
                    return $query->where('branch_id', $branchId);
                }),
            ],
            'items' => 'required|array|min:1',
            'items.*.inventory_id' => 'required|exists:inventories,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.discount_percentage' => 'nullable|numeric|min:0|max:100',

            // VALIDACIÓN A NIVEL DE ÍTEMS
            'items.*.payment_method' => 'required|string',
            //'items.*.payment_provider_id' => 'required_if:items.*.payment_method,!=,efectivo|nullable|exists:payment_providers,id',
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




        // 2. INICIAR TRANSACCIÓN
        DB::beginTransaction();

        try {
            $saleData = $request->except('items');
            $saleItems = $request->items;
            $branchId = $user->branch_id;
            $companyId = $user->company_id;
            Log::info('valor dedocument_id' . $request->document_id);

            // --- PRE-CHEQUEOS ---
            if (!Branch::find($branchId)) {
                return $this->errorGeneric('Sucursal inválida o no pertenece a su empresa.', 403);
            }

            //validar inventario de sucursales
            foreach ($request->items as $item) {

                // Buscar inventario
                $inventory = Inventory::find($item['inventory_id']);
                // Si no existe el producto
                if (!$inventory) {
                    return response()->json(
                        $this->errorMessage(
                            404,
                            'No puede vender producto/s. Pertenece/n a otra sucursal.',
                            ['inventory_id' => $item['inventory_id']]
                        ),
                        404
                    );
                }
                // Si pertenece a otra sucursal
                if ($inventory->branch_id !== auth()->user()->branch_id) {
                    return response()->json(
                        $this->errorMessage(
                            403,
                            'No puede vender este producto. Pertenece a otra sucursal.',
                            [
                                'inventory_id' => $inventory->id,
                                'item_branch' => $inventory->branch_id,
                                'user_branch' => auth()->user()->branch_id
                            ]
                        ),
                        403
                    );
                }
                // =============================
                // 3️⃣ Validar stock
                // =============================

                // Valores en inglés como pediste
                $requestedQty = (int) $item['quantity'];
                $availableStock = (int) $inventory->quantity;
                $outputUnit = (int) $inventory->output_unit;

                // 📌 Regla especial:
                // Si output_unit == quantity → NO hay stock disponible
                if ($outputUnit === $availableStock) {
                    return response()->json(
                        $this->errorMessage(
                            409,
                            'No hay stock disponible para el producto/s.',
                            [
                                'inventory_id' => $inventory->id,
                                'stock' => $availableStock,
                                'output_unit' => $outputUnit
                            ]
                        ),
                        409
                    );
                }

                // Regla general: stock insuficiente
                if ($requestedQty > $availableStock) {
                    return response()->json(
                        $this->errorMessage(
                            409,
                            'La cantidad solicitada supera el stock disponible.',
                            [
                                'inventory_id' => $inventory->id,
                                'requested' => $requestedQty,
                                'stock' => $availableStock
                            ]
                        ),
                        409
                    );
                }


            }


            // --- Lógica de Generación de Transaction Number Único (Global para la venta) ---
            $timestamp = now()->format('His');
            $microtime = now()->format('u');
            $randomId = strtoupper(substr(uniqid(), -5));

            $finalTransactionNumber = sprintf(
                "%s-%s-%s%s-%s",
                str_pad($companyId, 3, '0', STR_PAD_LEFT),
                str_pad($branchId, 5, '0', STR_PAD_LEFT),
                $timestamp,
                $microtime,
                $randomId
            );


            // --- 3. PROCESAR ÍTEMS y CÁLCULO DE TOTALES ---
            $totalAmount = 0;
            $totalTax = 0;
            $totalDiscount = 0;
            $itemsForCreation = [];
            $usedPaymentMethods = []; // Almacena métodos únicos usados (ej: ['Transferencia' => true, 'Efectivo' => true])

            foreach ($saleItems as $item) {
                // Buscamos el inventario fuera de scopes
                $inventory = Inventory::withoutGlobalScopes()->find($item['inventory_id']);

                if (!$inventory) {
                    DB::rollBack();
                    return $this->errorGeneric("Producto con ID {$item['inventory_id']} no encontrado.", 404);
                }

                // Validaciones (Stock, Descuento Máximo)
                $availableStock = $inventory->quantity - $inventory->output_unit;
                if ($availableStock < $item['quantity']) {
                    DB::rollBack();
                    return $this->errorGeneric("Stock insuficiente para el producto: {$inventory->name}. Stock disponible: {$availableStock}", 409);
                }

                // 🌟 CORRECCIÓN CRÍTICA: Usar net_price como precio base unitario
                $basePriceNetUnit = $inventory->net_price;
                $maxDiscountRate = $inventory->max_disscount ?? 0.00;
                $requestedDiscountRate = $item['discount_percentage'] ?? 0.00;

                // Validación de Descuento
                if ($requestedDiscountRate > $maxDiscountRate) {
                    DB::rollBack();
                    return $this->errorGeneric("El descuento solicitado ({$requestedDiscountRate}%) para el producto '{$inventory->name}' excede el máximo permitido ({$maxDiscountRate}%).", 403);
                }

                // 1. Cálculo del Precio Neto Total ANTES de Descuento (Base Inicial)
                $netPriceTotalBeforeDiscount = $basePriceNetUnit * $item['quantity'];

                // 2. Aplicar Descuento
                $actualDiscountRate = $requestedDiscountRate;
                $lineDiscount = $netPriceTotalBeforeDiscount * ($actualDiscountRate / 100);

                // 3. Calcular la Base Imponible de la Línea (Precio Neto Total después de descuento)
                $netPriceTotalAfterDiscount = $netPriceTotalBeforeDiscount - $lineDiscount;

                // 4. Calcular el Monto del IVA
                $lineTax = $netPriceTotalAfterDiscount * ($inventory->tax_sale / 100);

                // 5. Calcular el Total Final de la Línea (Precio Neto + IVA)
                $lineTotal = $netPriceTotalAfterDiscount + $lineTax;


                // 6. Acumular Totales Maestros
                // Acumulamos la Base Imponible (Neto Total después de descuento)
                $totalAmount += $netPriceTotalAfterDiscount;
                $totalTax += $lineTax;
                $totalDiscount += $lineDiscount;


                // Registrar el método de pago usado
                $itemPaymentMethod = $item['payment_method'];
                $itemPaymentProviderId = $item['payment_provider_id'] ?? null;
                $usedPaymentMethods[$itemPaymentMethod] = true;

                // Preparar detalle para SaleItem
                $itemsForCreation[] = [
                    'inventory_id' => $inventory->id,
                    'sku' => $inventory->sku,
                    'quantity' => $item['quantity'],
                    'unit_price' => $basePriceNetUnit, // Precio Neto Unitario
                    'tax_rate' => $inventory->tax_sale,
                    'discount_applied' => $lineDiscount,
                    'line_total' => $lineTotal,
                    // 🌟 AGREGAR BASE IMPONIBLE (NETO)
                    'net_price' => $netPriceTotalAfterDiscount,

                    // NUEVOS CAMPOS A NIVEL DE ITEM
                    'payment_method' => $itemPaymentMethod,
                    'payment_provider_id' => $itemPaymentProviderId,
                ];

                // Actualizar Inventario (Incrementa la salida)
                $inventory->increment('output_unit', $item['quantity']);
            }


            // 4. CREAR REGISTROS MAESTROS Y DETALLE
            //$grandTotal = $totalAmount + $totalTax - $totalDiscount;
            $grandTotal = $totalAmount + $totalTax;
            // La venta maestra registra todos los métodos usados como una lista separada por comas
            $primaryPaymentMethod = implode(', ', array_keys($usedPaymentMethods));



            $sale = Sale::create([
                'company_id' => $user->company_id,
                'branch_id' => $branchId,
                'user_id' => $user->id,
                'client_id' => $saleData['client_id'],

                'document_id' => $saleData['document_id'] ?? null,
                'number_transactions' => $finalTransactionNumber,
                // Estos campos se usan como resumen, el detalle está en sale_items
                'payment_provider_id' => null,
                'payment_method' => $primaryPaymentMethod,

                'sale_date' => now(),
                'invoice_number' => $saleData['invoice_number'] ?? null,
                'total_amount' => $totalAmount,
                'tax_amount' => $totalTax,
                'discount_amount' => $totalDiscount,
                'grand_total' => $grandTotal,
                'status' => $saleData['status'] ?? 'completed',
            ]);

            $sale->items()->createMany($itemsForCreation);

            // =========================================================
            // 5. LÓGICA DE CUENTAS POR COBRAR (PROCESADO POR ÍTEM)
            // =========================================================
            // Iteramos sobre los ítems recién creados para generar las Cuentas por Cobrar
            $sale->items->each(function ($item) use ($user, $branchId, $saleData, $sale) {
                if ($item->payment_provider_id) {
                    // Buscamos el proveedor de pago sin scopes para encontrarlo siempre
                    $provider = PaymentProvider::withoutGlobalScopes()->find($item->payment_provider_id);

                    // Si existe y está marcado para generar cuentas por cobrar (ej: Addi, Sistecrédito)
                    if ($provider && $provider->accounts_receivable) {
                        AccountReceivable::create([
                            'company_id' => $user->company_id,
                            'branch_id' => $branchId,
                            'sale_id' => $sale->id,
                            'payment_provider_id' => $provider->id,
                            'client_id' => $saleData['client_id'],
                            'amount' => $item->line_total, // La cantidad es SOLO el total de esta línea/ítem
                            'status' => 'pending',
                            'description' => "Cobro por ítem #{$item->inventory_id} de la venta {$sale->id}. Método: {$provider->name}",
                            'due_date' => $dueDate = Carbon::now()->addDays(30),
                        ]);
                        Log::info('Cuenta por Cobrar generada por ítem', ['sale_id' => $sale->id, 'item_id' => $item->id, 'provider' => $provider->name]);
                    }
                }
            });


            // 6. FINALIZAR LA TRANSACCIÓN
            DB::commit();

            // =========================================================
            // 7. GENERACIÓN ASÍNCRONA DE LA FACTURA
            // =========================================================
            $pdfFilename = 'invoice-' . $sale->id . '.pdf';
            $pdfUrl = null;

            try {
                // Llama a servicio de PDF
                $pdfContent = $this->pdfService->generateInvoice($sale);
                Storage::put('public/invoices/' . $pdfFilename, $pdfContent);
                $pdfUrl = url('/storage/invoices/' . $pdfFilename);


                Storage::put('public/invoices/test.txt', 'Funciona Storage!');


            } catch (\Exception $e) {
                Log::error('Fallo la generacion de PDF para la venta: ' . $sale->id . '. Error: ' . $e->getMessage());
            }

            // 8. RESPUESTA EXITOSA
            return response()->json(
                $this->successfullMessage(
                    201,
                    'Venta registrada exitosamente',
                    true,
                    1,
                    // Cargamos la relación de ítems para la respuesta
                    ['sale Detail' => $sale->load('items.paymentProvider', 'user'), 'invoice_url' => $pdfUrl]
                ),
                201
            );

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al procesar la venta (createSale): ' . $e->getMessage(), ['user_id' => $user->id, 'request' => $request->all()]);
            return response()->json(
                $this->errorGeneric('Error interno al procesar la venta. Por favor, contacte a soporte.', 500),
                500
            );
        }
    }



    /**
     * @OA\Post(
     * path="/api/admin/sales/{sale_id}/cancel",
     * summary="Anular una transacción de venta y revertir el inventario",
     * description="Marca la venta como cancelada (Soft Delete), cambia su estado a 'canceled' y revierte las unidades al inventario (decrementa output_unit).",
     * tags={"Gestión de Ventas"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="sale_id",
     * in="path",
     * required=true,
     * description="ID de la venta a anular.",
     * @OA\Schema(type="integer", example=10)
     * ),
     * @OA\Response(
     * response=200,
     * description="Venta anulada y stock revertido correctamente",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Venta anulada y stock devuelto exitosamente"),
     * @OA\Property(property="sale", type="object", description="Objeto de la venta cancelada.")
     * )
     * ),
     * @OA\Response(
     * response=403,
     * description="No autorizado (Venta no pertenece a la compañía/sucursal o ya está cancelada)",
     * @OA\JsonContent(@OA\Property(property="message", type="string", example="Venta no encontrada, ya cancelada, o no pertenece a su ámbito de operación."))
     * ),
     * @OA\Response(
     * response=404,
     * description="Venta no encontrada"
     * ),
     * @OA\Response(
     * response=500,
     * description="Error interno del servidor (rollback de la transacción)"
     * )
     * )
     */
    public function cancelSale($saleId)
    {

        $admin = auth()->user();


        log::info('Intento de anulación de venta', ['admin' => $admin->toArray()]);

        if ($admin->role_id === 'Administrador Sucursal' || $admin->role_id === 'Administrador Sucursal') {
            return response()->json($this->errorGeneric('No tiene permisos para eliminar ventas', 403), 403);
        }
        // 1. OBTENER VENTA (Con withTrashed() para asegurar que la buscamos incluso si ya fue eliminada suavemente)
        // El Global Scope todavía filtrará por company_id y branch_id.
        $sale = Sale::withTrashed()->find($saleId);

        if (!$sale) {
            // Error 404 (Not Found) si no existe dentro del ámbito del usuario
            return response()->json($this->errorGeneric('Venta no encontrada.', 404), 404);
        }


        if ($sale->status == 'canceled') {
            // Error 403 (Forbidden) si ya está cancelada
            return response()->json($this->errorGeneric('La venta ya se encuentra cancelada.', 403), 403);
        }

        // 2. Iniciar Transacción
        DB::beginTransaction();

        try {
            // 3. Revertir el stock para cada ítem de la venta
            // Usamos $sale->items para obtener los detalles de la venta (SaleItem)
            foreach ($sale->items as $item) {
                // Obtenemos el ítem de inventario
                $inventory = Inventory::find($item->inventory_id);

                if ($inventory) {
                    // **CLAVE:** Restar la cantidad vendida de 'output_unit' para revertir el movimiento.
                    // Usamos decrement para concurrencia segura.
                    $inventory->decrement('output_unit', $item->quantity);
                } else {
                    // Log de advertencia si el producto original se eliminó, pero el proceso continúa.
                    Log::warning("Inventario ID {$item->inventory_id} no encontrado durante la anulación de la Venta ID {$saleId}.");
                }
            }

            // 4. Marcar la venta como cancelada (cambio de status y Soft Delete)
            $sale->status = 'canceled';
            $sale->save();

            // Aplica el Soft Delete, estableciendo deleted_at
            $sale->delete();


            // 5. Finalizar la Transacción
            DB::commit();

            // 6. Respuesta Exitosa
            return response()->json(
                $this->successfullMessage(
                    200,
                    'Venta anulada y stock devuelto exitosamente',
                    true,
                    1,
                    // Devolvemos el objeto, ahora con el campo deleted_at lleno.
                    ['sale' => $sale]
                ),
                200
            );

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al anular la venta: ' . $e->getMessage(), ['sale_id' => $saleId, 'user_id' => auth()->id()]);

            return response()->json(
                $this->errorGeneric('Error interno al anular la venta. Por favor, contacte a soporte.', 500),
                500
            );
        }
    }





    /**
     * @OA\Get(
     * path="/api/sales",
     * summary="Lista todas las ventas con filtros y paginación",
     * description="Retorna una lista paginada de ventas, filtrada por la compañía/sucursal del usuario autenticado. Permite buscar y filtrar por fechas.",
     * tags={"Gestión de Ventas"},
     * security={{"bearerAuth":{}}},
     * * @OA\Parameter(
     * name="per_page",
     * in="query",
     * required=false,
     * description="Número de registros por página.",
     * @OA\Schema(type="integer", default=10, example=25)
     * ),
     * @OA\Parameter(
     * name="search",
     * in="query",
     * required=false,
     * description="Término de búsqueda parcial para número de factura o número de transacción.",
     * @OA\Schema(type="string", example="001-00001-")
     * ),
     * @OA\Parameter(
     * name="client_id",
     * in="query",
     * required=false,
     * description="Filtra ventas por el ID del cliente.",
     * @OA\Schema(type="integer", example=5)
     * ),
     * @OA\Parameter(
     * name="start_date",
     * in="query",
     * required=false,
     * description="Fecha de inicio del rango de búsqueda (Formato: YYYY-MM-DD).",
     * @OA\Schema(type="string", format="date", example="2025-10-01")
     * ),
     * @OA\Parameter(
     * name="end_date",
     * in="query",
     * required=false,
     * description="Fecha de fin del rango de búsqueda (Formato: YYYY-MM-DD).",
     * @OA\Schema(type="string", format="date", example="2025-10-31")
     * ),
     * * @OA\Response(
     * response=200,
     * description="Lista de ventas obtenida correctamente",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Listado de ventas obtenido exitosamente"),
     * @OA\Property(property="data", type="array",
     * @OA\Items(
     * @OA\Property(property="id", type="integer", example=213),
     * @OA\Property(property="sale_date", type="string", format="date-time", example="2025-11-25 03:31:01"),
     * @OA\Property(property="grand_total", type="number", format="float", example=246151.50),
     * @OA\Property(property="payment_method", type="string", example="Wompi, Addi"),
     * @OA\Property(property="number_transactions", type="string", example="027-00016-033101451295-6E2E2"),
     * @OA\Property(property="client", type="object", description="Cliente asociado a la venta"),
     * @OA\Property(property="user", type="object", description="Usuario que realizó la venta")
     * )
     * )
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Token de autenticación inválido o faltante."
     * ),
     * @OA\Response(
     * response=500,
     * description="Error interno del servidor."
     * )
     * )
     */
    /**
     * Lista todas las ventas con filtros y paginación.
     * Retorna TODAS las ventas de la Compañía y Sucursal del usuario autenticado.
     * * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listSales(Request $request)
    {
        // 1. Obtener el usuario autenticado (se usará en el catch y para logueo)
        $user = auth()->user();

        // 2. Definir Paginación
        $perPage = $request->get('per_page', 10);

        try {
            // 3. Consulta Base
            // El Sale::query() YA aplica los Global Scopes (CompanyScope y BranchScope)
            // por lo que trae automáticamente solo las ventas de la Sucursal del usuario.
            $query = Sale::withoutGlobalScopes()
                ->where('company_id', $user->company_id)
                ->where('branch_id', $user->branch_id);

            Log::debug('Listando ventas para usuario', ['user_id' => $user->id, 'company_id' => $user->company_id, 'branch_id' => $user->branch_id]);

            // 4. Carga de Relaciones (Eager Loading)
            $query->with(['client', 'user', 'branch']);

            // 5. Filtros Opcionales (Ejemplos)
            // Filtro por fecha (rango de fechas)
            if ($request->has('start_date') && $request->has('end_date')) {
                $query->whereBetween('sale_date', [$request->start_date, $request->end_date]);
            }

            // Filtro por ID de cliente (ESTE ES EL FILTRO, NO LA CONSULTA BASE)
            if ($request->has('client_id')) {
                $query->where('client_id', $request->client_id);
            }

            // Filtro por número de factura o número de transacción (Búsqueda parcial)
            // Filtro por número de factura, número de transacción O número de documento del cliente (Búsqueda parcial)
            if ($request->has('search')) {
                $searchTerm = '%' . $request->search . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('invoice_number', 'like', $searchTerm)
                        ->orWhere('number_transactions', 'like', $searchTerm);

                    // AÑADIDO: Filtro por número de documento del cliente
                    $q->orWhereHas('client', function ($clientQuery) use ($searchTerm) {
                        $clientQuery->where('document_number', 'like', $searchTerm)
                            ->orWhere('name', 'like', $searchTerm)
                            ->orWhere('email', 'LIKE', $searchTerm)
                            ->orWhere('phone', 'LIKE', $searchTerm)
                            ->orWhere('address', 'LIKE', $searchTerm)
                            ->orWhere('city', 'LIKE', $searchTerm)// Opcional: buscar también en dirección
                            ->orWhere('department', 'LIKE', $searchTerm)// Opcional: buscar también en dirección
                            ->orWhere('created_at', 'LIKE', $searchTerm);
                    });
                });
            }

            // 6. Ordenar (Por defecto, por la más reciente)
            $query->orderBy('created_at', 'desc');
            // 7. Ejecutar la consulta con Paginación
            $sales = $query->paginate($perPage);

            // 8. Respuesta Exitosa
            return response()->json(
                $this->successfullMessage(
                    200,
                    'Listado de ventas obtenido exitosamente',
                    true,
                    $sales->total(), // Conteo total
                    ['sales' => $sales] // La colección paginada
                ),
                200
            );

        } catch (\Exception $e) {
            Log::error('Error al listar ventas (listSales): ' . $e->getMessage(), ['user_id' => $user->id]);
            return response()->json(
                $this->errorGeneric('Error interno al listar ventas.', 500),
                500
            );
        }
    }
}

