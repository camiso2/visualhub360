<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Branch;
use App\Models\Supplier;
use App\Models\PaymentProvider;

use App\Services\PaymentProviderService;
use Illuminate\Support\Facades\DB;
use App\Custom\GeneratesInvoiceNumber;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Custom\ApiResponseTrait;
class InventoryController extends Controller
{

    use ApiResponseTrait, GeneratesInvoiceNumber;
    /**
     * @OA\Post(
     *     path="/api/admin/inventories",
     *     summary="Crear un nuevo producto en el inventario",
     *     tags={"Gestión de Inventario"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name", "quantity", "purchase_price", "sale_price", "image"},
     *
     *                 @OA\Property(property="name", type="string", example="Gafas de sol"),
     *                 @OA\Property(property="category", type="string", example="Anteojos"),
     *                 @OA\Property(property="description", type="string", example="Gafas de sol polarizadas para uso diario"),
     *                 @OA\Property(property="quantity", type="integer", example=25),
     *                 @OA\Property(property="min_stock", type="integer", example=5),
     *                 @OA\Property(property="purchase_price", type="number", format="float", example=120000),
     *                 @OA\Property(property="tax_purchase", type="number", format="float", example=19.00),
     *                 @OA\Property(property="sale_price", type="number", format="float", example=250000),
     *                 @OA\Property(property="tax_sale", type="number", format="float", example=19.00),
     *                 @OA\Property(property="max_disscount", type="number", format="float", example=10.00),
     *                 @OA\Property(property="number_invoice", type="string", example="FAC-2025-00023"),
     *                 @OA\Property(property="supplier_id", type="integer", example=2),
     *                 @OA\Property(property="image", type="string", format="binary"),
     *                 @OA\Property(property="image_invoice", type="string", format="binary"),
     *                 @OA\Property(property="active", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Producto creado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="integer", example=201),
     *             @OA\Property(property="message", type="string", example="Producto creado correctamente"),
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="total", type="integer", example=1),
     *             @OA\Property(property="inventory", type="object",
     *
     *                 @OA\Property(property="id", type="integer", example=15),
     *                 @OA\Property(property="company_id", type="integer", example=1),
     *                 @OA\Property(property="sku", type="string", example="001000123"),
     *                 @OA\Property(property="name", type="string", example="Anillo de plata 925"),
     *                 @OA\Property(property="category", type="string", example="Anillos"),
     *                 @OA\Property(property="description", type="string", example="Anillo artesanal con zirconia"),
     *                 @OA\Property(property="quantity", type="integer", example=25),
     *                 @OA\Property(property="min_stock", type="integer", example=5),
     *                 @OA\Property(property="purchase_price", type="number", example=120000),
     *                 @OA\Property(property="tax_purchase", type="number", example=19.00),
     *                 @OA\Property(property="sale_price", type="number", example=250000),
     *                 @OA\Property(property="tax_sale", type="number", example=19.00),
     *                 @OA\Property(property="max_disscount", type="number", example=10.00),
     *                 @OA\Property(property="number_invoice", type="string", example="FAC-2025-00023"),
     *                 @OA\Property(property="supplier_id", type="integer", example=2),
     *                 @OA\Property(property="image", type="string", example="/inventories/uuid1234.png"),
     *                 @OA\Property(property="image_invoice", type="string", example="/invoices/uuid1234.png"),
     *                 @OA\Property(property="active", type="boolean", example=true),
     *                 @OA\Property(property="created_at", type="string", example="2025-11-04T14:35:00Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2025-11-04T14:40:00Z")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=403,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No tiene permisos para crear inventario")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */

    public function createInventory(Request $request)
    {
        try {

            if ($request->has('active')) {
                $request->merge([
                    'active' => filter_var($request->active, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
                ]);
            }

            $rules = [
                'name' => 'required|string|max:255',
                'category' => 'nullable|string|max:100',
                'description' => 'nullable|string',
                'quantity' => 'required|integer|min:0',
                'min_stock' => 'nullable|integer|min:0',
                'purchase_price' => 'required|numeric|min:0',
                'tax_purchase' => 'nullable|numeric|min:0|max:100',
                //'sale_price' => 'required|numeric|min:0',
                'max_disscount' => 'required|numeric|min:0',
                'sale_price' => 'required|numeric|min:0|gte:purchase_price',// Usando la sintaxis de Laravel (min:otro_campo)
                'tax_sale' => 'nullable|numeric|min:0|max:100',
                'number_invoice' => 'nullable|string|max:100',
                'supplier_id' => 'nullable|exists:suppliers,id',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'image_invoice' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
                'active' => 'nullable|boolean'
            ];

            $messages = [
                // El mensaje aparecerá si la regla GTE falla
                'sale_price.gte' => 'El precio de venta no puede ser inferior al precio de compra.',
            ];

            // Validación de campos
            $validator = Validator::make($request->all(), $rules, $messages);

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


            Log::info('Creating inventory item', [
                'request_payload' => $request->all(),
                'user_id' => auth()->id() //
            ]);
            $user = auth()->user();



            // Validar que la sucursal pertenezca a la empresa
            $branch = Branch::where('id', $user->branch_id)
                ->where('company_id', $user->company_id)
                ->first();

            if (!$branch) {
                return response()->json($this->errorGeneric('Sucursal no encontrada o no pertenece a su empresa', 404), 404);
            }

            // Convertir campo active a boolean
            if ($request->has('active')) {
                $request->merge(['active' => filter_var($request->active, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)]);
            }

            // Roles autorizados
            $allowedRoles = ['Administrador General', 'Asesor Interno', 'Administrador Sucursal'];
            if (!in_array($user->role?->name, $allowedRoles) && $user->role_id !== null) {
                return response()->json($this->errorGeneric('No tiene permisos para crear inventario', 403), 403);
            }



            // Manejo de imágenes
            $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('inventories'), $filename);
                $imagePath = '/inventories/' . $filename;
            }

            $invoiceImagePath = null;
            if ($request->hasFile('image_invoice')) {
                $file = $request->file('image_invoice');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('invoices'), $filename);
                $invoiceImagePath = '/invoices/' . $filename;
            }

            // Generar SKU único por empresa
            $lastProduct = Inventory::where('company_id', $user->company_id)->orderBy('id', 'desc')->first();
            $nextNumber = $lastProduct ? ((int) substr($lastProduct->sku, -6)) + 1 : 1;
            $sku = str_pad($user->company_id, 5, '0', STR_PAD_LEFT) . str_pad($user->branch_id, 3, '0', STR_PAD_LEFT) . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);


           /* $base_price = (float) $request->sale_price;
            $tax_rate_percentage = (float) $request->tax_sale; // e.g., 19 (for 19%)

            // 2. Calcular el monto del IVA
            // Fórmula: Monto_IVA = Precio_Base * (Tasa_IVA / 100)
            $tax_amount = $base_price * ($tax_rate_percentage / 100);



            // 3. Calcular el precio total (base + IVA)
            $final_sale_price_with_tax = $base_price + $tax_amount;*/
             $finalSalePrice = (float) $request->sale_price;   // precio con IVA
                $taxSalePercent = (float) $request->tax_sale;     // porcentaje IVA

                // Extraer el precio neto correctamente
                $netPrice = $finalSalePrice / (1 + ($taxSalePercent / 100));
            // Crear producto
            $inventory = Inventory::create([
                'company_id' => $user->company_id,
                'branch_id' => $user->branch_id,
                'sku' => $sku,
                'name' => $request->name,
                'category' => $request->category,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'output_unit' => 0,
                'min_stock' => $request->min_stock,
                'purchase_price' => $request->purchase_price,
                'tax_purchase' => $request->tax_purchase,
                'net_price' => $netPrice,
                'sale_price' => $request->sale_price,
                'tax_sale' => $request->tax_sale,
                'max_disscount' => $request->max_disscount,
                'number_invoice' => $request->number_invoice,
                'supplier_id' => $request->supplier_id,
                'image' => $imagePath,
                'image_invoice' => $invoiceImagePath,
                'active' => $request->active ?? true,
                'user_id' => $user->id,
            ]);

            return response()->json(
                $this->successfullMessage(201, 'Producto creado correctamente', true, 1, ['inventory' => $inventory])
            );

        } catch (\Exception $e) {
            Log::error("Error creating inventory: " . $e->getMessage());
            return response()->json($this->errorGeneric('Error al crear inventario: ' . $e->getMessage(), 500), 500);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/admin/inventories/{id}",
     *     summary="Actualizar un producto del inventario",
     *     tags={"Gestión de Inventario"},
     *     security={{"bearerAuth":{}}},

    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="ID del producto a actualizar",
    *         @OA\Schema(type="integer", example=15)
    *     ),

    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 @OA\Property(property="branch_id", type="integer", example=7),
    *                 @OA\Property(property="name", type="string", example="Gafas de sol polarizadas"),
    *                 @OA\Property(property="category", type="string", example="Anteojos"),
    *                 @OA\Property(property="description", type="string", example="Gafas polarizadas con filtro UV"),
    *                 @OA\Property(property="quantity", type="integer", example=30),
    *                 @OA\Property(property="min_stock", type="integer", example=5),
    *                 @OA\Property(property="purchase_price", type="number", format="float", example=150000),
    *                 @OA\Property(property="sale_price", type="number", format="float", example=280000),
    *                 @OA\Property(property="tax_purchase", type="number", format="float", example=19.0, description="Impuesto de compra (%)"),
    *                 @OA\Property(property="tax_sale", type="number", format="float", example=19.0, description="Impuesto de venta (%)"),
    *                 @OA\Property(property="max_disscount", type="number", format="float", example=10.00, description="maximo descuento de venta de venta (%)"),
    *                 @OA\Property(property="number_invoice", type="string", example="FAC-00012345"),
    *                 @OA\Property(property="supplier_id", type="integer", example=2, description="ID del proveedor asociado"),
    *                 @OA\Property(property="image", type="string", format="binary", description="Nueva imagen del producto (opcional)"),
    *                 @OA\Property(property="image_invoice", type="string", format="binary", description="Imagen de la factura de compra (opcional)"),
    *                 @OA\Property(property="active", type="boolean", example=true)
    *             )
    *         )
    *     ),

    *     @OA\Response(
    *         response=200,
    *         description="Producto actualizado correctamente",
    *         @OA\JsonContent(
    *             @OA\Property(property="code", type="integer", example=200),
    *             @OA\Property(property="message", type="string", example="Producto actualizado correctamente"),
    *             @OA\Property(property="success", type="boolean", example=true),
    *             @OA\Property(property="total", type="integer", example=1),
    *             @OA\Property(property="inventory", type="object")
    *         )
    *     ),

    *     @OA\Response(
    *         response=403,
    *         description="No autorizado",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="No tiene permisos para actualizar inventario")
    *         )
    *     ),

    *     @OA\Response(
    *         response=404,
    *         description="Producto no encontrado o no pertenece a la empresa"
    *     ),

    *     @OA\Response(
    *         response=422,
    *         description="Error de validación"
    *     )
    * )
    */
    public function updateInventory(Request $request, $id)
    {
        try {
            $user = auth()->user();

            // Convertir active a boolean si existe
            if ($request->has('active')) {
                $request->merge([
                    'active' => filter_var($request->active, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
                ]);
            }

            // ------------------------------
            // 1. VALIDACIÓN
            // ------------------------------
            $rules = [
                'branch_id' => 'nullable|integer|exists:branches,id',
                'name' => 'required|string|max:255',
                'category' => 'nullable|string|max:100',
                'description' => 'nullable|string',
                'quantity' => 'required|integer|min:0',
                'min_stock' => 'nullable|integer|min:0',

                // precios base
                'purchase_price' => 'required|numeric|min:0',
                'tax_purchase' => 'nullable|numeric|min:0|max:100',

                // precio venta sin IVA
                'sale_price' => 'required|numeric|min:0|gte:purchase_price',
                'tax_sale' => 'nullable|numeric|min:0|max:100',

                'max_disscount' => 'required|numeric|min:0|max:100',
                'number_invoice' => 'nullable|string|max:100',
                'supplier_id' => 'nullable|integer|exists:suppliers,id',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'image_invoice' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
                'active' => 'nullable|boolean',
            ];

            $validator = Validator::make($request->all(), $rules, [
                'sale_price.gte' => 'El precio de venta no puede ser inferior al precio de compra.',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    $this->errorMessage(422, 'Error de validación', ['errors' => $validator->errors()]),
                    422
                );
            }

            // ------------------------------
            // 2. BUSCAR INVENTARIO
            // ------------------------------
            $inventory = Inventory::where('company_id', $user->company_id)
                ->where('id', $id)
                ->first();

            if (!$inventory) {
                return response()->json($this->errorGeneric('Producto no encontrado o no pertenece a su empresa', 404), 404);
            }

            // ------------------------------
            // 3. PERMISOS
            // ------------------------------
            $allowedRoles = ['Administrador General', 'Administrador Sucursal'];
            if (!in_array($user->role?->name, $allowedRoles) && $user->role_id !== null) {
                return response()->json($this->errorGeneric('No tiene permisos para actualizar inventario', 403), 403);
            }

            // ------------------------------
            // 4. CAMBIO DE SUCURSAL
            // ------------------------------
            if ($request->has('branch_id')) {
                $branch = Branch::where('id', $request->branch_id)
                    ->where('company_id', $user->company_id)
                    ->first();

                if (!$branch) {
                    return response()->json($this->errorGeneric('Sucursal no pertenece a su empresa', 403), 403);
                }

                $inventory->branch_id = $request->branch_id;
            }

            // ------------------------------
            // 5. IMÁGENES
            // ------------------------------
            if ($request->hasFile('image')) {
                if ($inventory->image && file_exists(public_path($inventory->image))) {
                    @unlink(public_path($inventory->image));
                }

                $file = $request->file('image');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('inventories'), $filename);
                $inventory->image = '/inventories/' . $filename;
            }

            if ($request->hasFile('image_invoice')) {
                if ($inventory->image_invoice && file_exists(public_path($inventory->image_invoice))) {
                    @unlink(public_path($inventory->image_invoice));
                }

                $file = $request->file('image_invoice');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('invoices'), $filename);
                $inventory->image_invoice = '/invoices/' . $filename;
            }

            // ------------------------------
            // 6. CAMPOS NORMALES
            // ------------------------------
            $dataToFill = $request->only([
                'name',
                'category',
                'description',
                'quantity',
                'min_stock',
                'purchase_price',
                'tax_purchase',
                'tax_sale',
                'max_disscount',
                'number_invoice',
                'supplier_id',
                'active'
            ]);

            // ------------------------------
            // 7. PRECIOS SOLO SI CAMBIARON
            // ------------------------------

            // ------------------------------
            // 7. MANEJO DEL PRECIO DE VENTA (VIENE CON IVA INCLUIDO)
            // ------------------------------

            if ($request->has('sale_price')) {

                $finalSalePrice = (float) $request->sale_price;   // precio con IVA
                $taxSalePercent = (float) $request->tax_sale;     // porcentaje IVA

                // Extraer el precio neto correctamente
                $netPrice = $finalSalePrice / (1 + ($taxSalePercent / 100));

                // Calcular el IVA en pesos
                $taxAmount = $finalSalePrice - $netPrice;

                $dataToFill['net_price'] = round($netPrice, 2);
                $dataToFill['tax_sale'] = $taxSalePercent;
                $dataToFill['sale_price'] = round($finalSalePrice, 2);
                $dataToFill['tax_sale_amount'] = round($taxAmount, 2); // opcional
            }

            // ------------------------------
            // 8. GUARDAR
            // ------------------------------
            $inventory->fill($dataToFill);
            $inventory->save();

            return response()->json(
                $this->successfullMessage(
                    200,
                    'Producto actualizado correctamente',
                    true,
                    1,
                    ['inventory' => $inventory]
                )
            );

        } catch (\Exception $e) {
            Log::error("Error updating inventory: " . $e->getMessage());
            return response()->json($this->errorGeneric('Error al actualizar inventario: ' . $e->getMessage(), 500), 500);
        }
    }


    /**
     * @OA\Get(
     * path="/api/inventories/branch",
     * summary="Listar inventario de una sucursal con totales, ganancias, porcentajes, antigüedad y proveedor",
     * tags={"Gestión de Inventario"},
     * security={{"bearerAuth":{}}},
     *
     * @OA\Parameter(
     * name="per_page",
     * in="query",
     * required=false,
     * description="Ítems por página",
     * @OA\Schema(type="integer", default=10)
     * ),
     *
     * @OA\Response(
     * response=200,
     * description="Inventario obtenido correctamente",
     * @OA\JsonContent()
     * )
     * )
     */
    // 🚨 Nota: Asegúrate de tener 'use Illuminate\Support\Facades\DB;' y 'use App\Models\Inventory;' (o el nombre de tu modelo)
// y que tu modelo Inventory tiene las relaciones 'supplier' y 'user' definidas.

    public function getBranchInventories(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $user = auth()->user();

        try {

            /* --------------------------------------------------------------------------
             | 0. Validar sucursal del usuario
            ---------------------------------------------------------------------------*/
            $branch = Branch::where('id', $user->branch_id)
                ->where('company_id', $user->company_id)
                ->first();

            if (!$branch) {
                return response()->json(
                    $this->errorGeneric('Sucursal no encontrada o no pertenece a su empresa', 404),
                    404
                );
            }

            /* --------------------------------------------------------------------------
             | Base query
            ---------------------------------------------------------------------------*/
            $baseQuery = Inventory::where('company_id', $user->company_id)
                ->where('branch_id', $user->branch_id);

            /* --------------------------------------------------------------------------
             | 1. Totales globales (no dependen de búsqueda)
            ---------------------------------------------------------------------------*/
            $globalTotals = DB::table('inventories')
                ->where('company_id', $user->company_id)
                ->where('branch_id', $user->branch_id)
                ->where('active', true)
                ->selectRaw('
                SUM(quantity * purchase_price) AS inventory_total_value_purchase,
                SUM(quantity * sale_price) AS inventory_total_value_sale,
                SUM(quantity * (sale_price - purchase_price)) AS inventory_total_profit
            ')->first();

            $totalValuePurchase = $globalTotals->inventory_total_value_purchase ?? 0;
            $totalValueSale = $globalTotals->inventory_total_value_sale ?? 0;
            $totalProfit = $globalTotals->inventory_total_profit ?? 0;


            /* --------------------------------------------------------------------------
             | 2. Filtro de búsqueda
            ---------------------------------------------------------------------------*/
            $inventoriesQuery = clone $baseQuery;

            if ($search) {
                $inventoriesQuery->where(function ($query) use ($search) {

                    // Búsqueda exacta
                    $query->where('sku', $search)
                        ->orWhere('number_invoice', $search);

                    // Parcial
                    $query->orWhere('sku', 'like', "%$search%")
                        ->orWhere('number_invoice', 'like', "%$search%")
                        ->orWhere('name', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%")
                        ->orWhere('category', 'like', "%$search%")
                        ->orWhere('sale_price', 'like', "%$search%")
                        ->orWhere('tax_sale', 'like', "%$search%")
                        ->orWhere('purchase_price', 'like', "%$search%");

                    // Usuario
                    $query->orWhereHas(
                        'user',
                        fn($q) =>
                        $q->where('name', 'like', "%$search%")
                    );

                    // Proveedor
                    $query->orWhereHas(
                        'supplier',
                        fn($q) =>
                        $q->where('name', 'like', "%$search%")
                    );
                });
            }

            /* --------------------------------------------------------------------------
             | 3. Paginación
            ---------------------------------------------------------------------------*/
            $inventoriesPaginated = $inventoriesQuery
                ->with(['supplier', 'user'])
                ->orderByDesc('created_at')
                ->paginate($perPage);

            $today = now();

            /* --------------------------------------------------------------------------
             | 4. Transformación de cada item
            ---------------------------------------------------------------------------*/
            $inventoriesPaginated->getCollection()->transform(function ($item) use ($today) {

                /* -------------------------------------------------------------
                 | A. Totales base
                --------------------------------------------------------------*/
                $item->total_value_purchase = $item->quantity * $item->purchase_price;
                $item->total_value_sale = $item->quantity * $item->sale_price;

                $item->quantityToGenerate = $item->quantity - $item->output_unit;

                $item->days_in_inventory = $today->diffInDays($item->created_at);

                /* -------------------------------------------------------------
                 | 🔥 B. Cálculo CORRECTO de IVA y utilidad
                --------------------------------------------------------------*/

                // Venta SIN IVA
                $salePriceWithoutTax = $item->sale_price / (float)((100 + $item->tax_sale)/100);//1.19;
                Log::debug("Calculating profits for item #{} ", ['nuemro ::::::: text sale'=>(float)((100 + $item->tax_sale)/100)]);

                // Utilidad bruta
                $item->unit_profit = /*$item->sale_price*/$salePriceWithoutTax - $item->purchase_price;

                // Utilidad neta (sin IVA)
                $item->unit_profit_after_tax = $salePriceWithoutTax - $item->purchase_price;

                // Totales
                $item->total_profit = $item->unit_profit * $item->quantity;
                $item->total_profit_after_tax = $item->unit_profit_after_tax * $item->quantity;

                /* -------------------------------------------------------------
                 | C. Porcentajes
                --------------------------------------------------------------*/
                /*$item->profit_percent = $item->purchase_price > 0
                    ? round(($item->unit_profit / $item->purchase_price) * 100, 2)
                    : 0;*/
                // Usa la utilidad neta (sin IVA) en el numerador
                $item->profit_percent = $item->purchase_price > 0
                    ? round(($item->unit_profit_after_tax / $item->purchase_price) * 100, 2) // ✅ CORRECTO: Usa unit_profit_after_tax
                    : 0;

                $item->total_profit_percent = $item->total_value_purchase > 0
                    ? round(($item->total_profit / $item->total_value_purchase) * 100, 2)
                    : 0;

                /* -------------------------------------------------------------
                 | D. Exposición al frontend
                --------------------------------------------------------------*/
                $item->profit_detail = [
                    'unit_purchase_price' => $item->purchase_price,
                    'unit_sale_price' => $item->sale_price,
                    'unit_profit' => $item->unit_profit,
                    'unit_profit_after_tax' => $item->unit_profit_after_tax,
                    'unit_profit_percent' => $item->profit_percent,
                ];

                $item->total_detail = [
                    'quantity' => $item->quantity,
                    'total_value_purchase' => $item->total_value_purchase,
                    'total_value_sale' => $item->total_value_sale,
                    'total_profit' => $item->total_profit,
                    'total_profit_after_tax' => $item->total_profit_after_tax,
                    'total_profit_percent' => $item->total_profit_percent,
                ];

                /* -------------------------------------------------------------
                 | E. Datos del proveedor
                --------------------------------------------------------------*/
                $item->supplier_info = $item->supplier ? [
                    'id' => $item->supplier->id,
                    'name' => $item->supplier->name,
                    'document_number' => $item->supplier->document_number,
                    'email' => $item->supplier->email,
                    'phone' => $item->supplier->phone,
                    'address' => $item->supplier->address,
                    'created_at' => optional($item->supplier->created_at)->toDateString(),
                ] : null;

                return $item;
            });

            /* --------------------------------------------------------------------------
             | 5. Porcentaje global
            ---------------------------------------------------------------------------*/
            $inventoryProfitPercent = $totalValuePurchase > 0
                ? round((($totalValueSale - $totalValuePurchase) / $totalValuePurchase) * 100, 2)
                : 0;

            return response()->json(
                $this->successfullMessage(
                    201,
                    'Inventario obtenido correctamente',
                    true,
                    $inventoriesPaginated->total(),
                    [
                        'inventory_total_value_purchase' => $totalValuePurchase,
                        'inventory_total_value_sale' => $totalValueSale,
                        'inventory_total_profit' => $totalProfit,
                        'inventory_profit_percent' => $inventoryProfitPercent,
                        'inventories' => $inventoriesPaginated,
                        'last_number' => $this->getNextInvoiceNumber($user),
                    ]
                ),
                201
            );

        } catch (\Exception $e) {

            Log::error("Error listing inventories: " . $e->getMessage());

            return response()->json(
                $this->errorGeneric('Error al obtener inventario: ' . $e->getMessage(), 500),
                500
            );
        }
    }


    /**
     * @OA\Get(
     *     path="/api/admin/inventories/branch/{branch_id}/sku/{sku}",
     *     summary="Buscar producto por SKU en una sucursal con detalles completos",
     *     tags={"Gestión de Inventario"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="branch_id",
     *         in="path",
     *         required=true,
     *         description="ID de la sucursal",
     *         @OA\Schema(type="integer", example=7)
     *     ),
     *     @OA\Parameter(
     *         name="sku",
     *         in="path",
     *         required=true,
     *         description="Código SKU del producto",
     *         @OA\Schema(type="string", example="EMP-001-000245")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto encontrado correctamente",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado o sin permisos"
     *     )
     * )
     */
    public function getInventoryBySku($branch_id, $sku)
    {
        try {
            $user = auth()->user();

            // Verificar que la sucursal pertenece a la empresa
            // 1. VERIFICACIÓN DE LA SUCURSAL (Limpio gracias al CompanyScope en el modelo Branch)
            // El CompanyScope en el modelo Branch ya asegura que solo se busquen Branches
            // que pertenezcan a la compañía del usuario autenticado.
            // $branch = Branch::find($branch_id);

            if (!Branch::find($branch_id)) {
                // Si no se encuentra, es porque la sucursal no existe O no pertenece a la compañía.
                return response()->json(
                    $this->errorGeneric('Sucursal no encontrada o no pertenece a su empresa', 404),
                    404
                );
            }

            // Roles permitidos
            $allowedRoles = [null, 'Administrador Sucursal'];
            if (!in_array($user->role?->name, $allowedRoles) && $user->role_id !== null) {
                return response()->json(
                    $this->errorGeneric('No tiene permisos para ver este inventario', 403),
                    403
                );
            }

            // Buscar producto activo por SKU
            $item = Inventory::where('company_id', $user->company_id)
                ->where('branch_id', $branch_id)
                ->where('sku', $sku)
                ->where('active', true)
                ->with('supplier')
                ->with('user') //Incluye relación con el user
                ->first();

            if (!$item) {
                return response()->json(
                    $this->errorGeneric('Producto no encontrado en esta sucursal o inactivo', 404),
                    404
                );
            }

            $today = now();

            // Cálculos detallados del producto
            $item->total_value_purchase = $item->quantity * $item->purchase_price;
            $item->total_value_sale = $item->quantity * $item->sale_price;

            // Ganancias
            $item->unit_profit = $item->sale_price - $item->purchase_price;
            $item->total_profit = $item->unit_profit * $item->quantity;

            // Ganancia neta después de impuestos
            $item->unit_profit_after_tax = ($item->sale_price - $item->tax_sale) - ($item->purchase_price + $item->tax_purchase);
            $item->total_profit_after_tax = $item->unit_profit_after_tax * $item->quantity;

            // Porcentajes
            $item->profit_percent = $item->purchase_price > 0
                ? round(($item->unit_profit / $item->purchase_price) * 100, 2)
                : 0;

            $item->total_profit_percent = $item->total_value_purchase > 0
                ? round((($item->total_value_sale - $item->total_value_purchase) / $item->total_value_purchase) * 100, 2)
                : 0;

            // Antigüedad del producto
            $item->days_in_inventory = $today->diffInDays($item->created_at);

            // Detalles unitarios y totales
            $item->profit_detail = [
                'unit_purchase_price' => $item->purchase_price,
                'unit_sale_price' => $item->sale_price,
                'unit_profit' => $item->unit_profit,
                'unit_profit_after_tax' => $item->unit_profit_after_tax,
                'unit_profit_percent' => $item->profit_percent,
            ];

            $item->total_detail = [
                'quantity' => $item->quantity,
                'total_value_purchase' => $item->total_value_purchase,
                'total_value_sale' => $item->total_value_sale,
                'total_profit' => $item->total_profit,
                'total_profit_after_tax' => $item->total_profit_after_tax,
                'total_profit_percent' => $item->total_profit_percent,
            ];

            // Proveedor
            $item->supplier_info = $item->supplier ? [
                'id' => $item->supplier->id,
                'name' => $item->supplier->name,
                'document_number' => $item->supplier->document_number,
                'email' => $item->supplier->email,
                'phone' => $item->supplier->phone,
                'address' => $item->supplier->address,
                'created_at' => $item->supplier->created_at?->toDateString(),
            ] : null;

            return response()->json(
                $this->successfullMessage(
                    200,
                    'Producto encontrado correctamente',
                    true,
                    1,
                    ['item' => $item]
                )
            );

        } catch (\Exception $e) {
            Log::error("Error getting inventory by SKU: " . $e->getMessage());
            return response()->json(
                $this->errorGeneric('Error al obtener el producto: ' . $e->getMessage(), 500),
                500
            );
        }
    }

    /**
     * @OA\Post(
     * path="/api/inventory/searchBySku",
     * summary="Buscar un producto de inventario por su número de SKU",
     * tags={"Gestión de Inventario"},
     * security={{"bearerAuth":{}}},
     *
     * @OA\RequestBody(
     * required=true,
     * description="SKU del producto a buscar en el inventario",
     * @OA\JsonContent(
     * required={"sku"},
     * @OA\Property(
     * property="sku",
     * type="string",
     * example="00027016000003",
     * description="Número de SKU del producto"
     * )
     * )
     * ),
     *
     * @OA\Response(
     * response=201,
     * description="Producto encontrado exitosamente (incluye datos del proveedor)",
     * @OA\JsonContent(
     * @OA\Property(property="code", type="integer", example=201),
     * @OA\Property(property="message", type="string", example="Producto encontrado"),
     * @OA\Property(property="success", type="boolean", example=true),
     * @OA\Property(property="count", type="integer", example=1),
     * @OA\Property(
     * property="data",
     * type="object",
     * @OA\Property(
     * property="inventory",
     * type="object",
     * nullable=true,
     * description="Objeto completo del inventario encontrado",
     * @OA\Property(property="id", type="integer", example=101),
     * @OA\Property(property="document_number", type="string", example="00027016000003"),
     * @OA\Property(property="name", type="string", example="Monitor LED 27 Pulgadas"),
     * @OA\Property(property="stock", type="integer", example=50),
     * @OA\Property(
     * property="supplier",
     * type="object",
     * description="Detalles del proveedor (cargados mediante load('supplier'))",
     * @OA\Property(property="id", type="integer", example=5),
     * @OA\Property(property="name", type="string", example="Tech Global S.A."),
     * @OA\Property(property="contact_person", type="string", example="María L. González"),
     * @OA\Property(property="phone", type="string", example="555-1234")
     * )
     * )
     * )
     * )
     * ),
     *
     * @OA\Response(
     * response=404,
     * description="Producto no encontrado",
     * @OA\JsonContent(
     * @OA\Property(property="code", type="integer", example=201),
     * @OA\Property(property="message", type="string", example="Producto no encontrado"),
     * @OA\Property(property="success", type="boolean", example=false),
     * @OA\Property(property="count", type="integer", example=0),
     * @OA\Property(property="data", type="object", example={"inventory": null})
     * )
     * ),
     *
     * @OA\Response(
     * response=422,
     * description="Error de validación (El campo sku es requerido)"
     * ),
     *
     * @OA\Response(
     * response=500,
     * description="Error interno del servidor"
     * )
     * )
     */
    public function searchBySku(Request $request)
    {
        try {
            $request->validate([
                'sku' => 'required|string'
            ]);
            $inventory = Inventory::bySku($request->sku)->with('supplier')->first();

            $paymentProviders = PaymentProvider::all();

            if ($paymentProviders->isEmpty() || $paymentProviders->count() === 0) {
                $user = auth()->user();
                $branch = $user->branch->id;
                $company = $user->company->id;
                $paymentProvidersRegister = new PaymentProviderService();
                $paymentProvidersRegister->seedDefaultProviders($company, $branch);
                $paymentProviders = PaymentProvider::all();
            }


            // 3. LÓGICA CLAVE: Reordenar para que 'Efectivo' quede primero
            $efectivoProvider = $paymentProviders->firstWhere('name', 'Efectivo');

            if ($efectivoProvider) {
                // A) Quitar 'Efectivo' de su posición actual
                $paymentProviders = $paymentProviders->reject(function ($provider) use ($efectivoProvider) {
                    // Asume que el ID es la clave única para rechazar
                    return $provider->id === $efectivoProvider->id;
                });

                // B) Poner 'Efectivo' al principio de la colección
                $paymentProviders = $paymentProviders->prepend($efectivoProvider);


            }
            Log::info(' el valor de paymentent provider ; ', ['payment' => $paymentProviders]);
            // 4. Modificar el objeto $inventory para añadir la lista de proveedores
            if ($inventory) {
                // Usamos values() para asegurar que las claves sean numéricas (0, 1, 2...)
                $inventory->paymentProviders = $paymentProviders->values();
            }
            return response()->json(
                $this->successfullMessage(
                    201,
                    $inventory ? 'Producto encontrado en el Inventario' : 'Producto no encontrado en el Inventario',
                    (bool) $inventory,
                    $inventory ? 1 : 0,
                    ['inventory' => $inventory]
                ),
                201
            );
        } catch (\Exception $e) {
            Log::info("Error exception obtener  inventario./" . $e->getMessage());
            return response()->json($this->eMessageError($e->getMessage(), 'Error al obtener  inventario'), 500);
        }
    }

}
