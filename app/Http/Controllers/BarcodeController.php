<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Services\BarcodePdfService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Inventory; //
use App\Models\company; //

class BarcodeController extends Controller
{
    protected $barcodePdfService;

    public function __construct(BarcodePdfService $barcodePdfService)
    {
        $this->barcodePdfService = $barcodePdfService;
    }





    /**
     * @OA\Post(
     * path="/api/inventory/generateBarcodes",
     * summary="Generar un PDF con códigos de barras para ítems de inventario seleccionados.",
     * tags={"Gestión de Inventario"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"items_to_generate"},
     * @OA\Property(
     * property="items_to_generate",
     * type="array",
     * description="Lista de ítems de inventario con la cantidad de códigos de barras a generar para cada uno.",
     * @OA\Items(
     * type="object",
     * required={"inventory_id", "quantity"},
     * @OA\Property(property="inventory_id", type="integer", example=4, description="ID del ítem de inventario."),
     * @OA\Property(property="quantity", type="integer", example=5, description="Número de etiquetas a generar para este ítem.")
     * )
     * )
     * )
     * ),
     * @OA\Response(response=200, description="PDF generado y listo para descarga.")
     * )
     */
    public function createInventoryBarcodes(Request $request)
    {


        // 1. Nueva Validación
        $validator = Validator::make($request->all(), [
            'items_to_generate' => 'required|array|min:1',
            'items_to_generate.*.inventory_id' => 'required|integer|exists:inventories,id', // Válida que el ID exista
            'items_to_generate.*.quantity' => 'required|integer|min:1|max:1000', // Cantidad de códigos
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Error de validación.', 'errors' => $validator->errors()], 422);
        }

        try {
            $itemsToGenerate = $request->input('items_to_generate');

            // 2. Extraer IDs únicos para una sola consulta a la DB
            $inventoryIds = collect($itemsToGenerate)->pluck('inventory_id')->unique()->toArray();

            // 3. Buscar ítems en la DB y mapearlos por ID
            $inventoryItemsDB = Inventory::whereIn('id', $inventoryIds)
                ->get(['id', 'sku', 'name'])
                ->keyBy('id'); // Mapear por ID para acceso rápido

            // 4. Preparar la lista final APLANADA (un elemento por cada etiqueta a imprimir)

            $finalItemsList = [];

            foreach ($itemsToGenerate as $itemRequest) {

                $itemId = $itemRequest['inventory_id'];
                $quantity = $itemRequest['quantity'];

                if (!isset($inventoryItemsDB[$itemId]))
                    continue;

                $item = $inventoryItemsDB[$itemId];

                for ($i = 0; $i < $quantity; $i++) {
                    $finalItemsList[] = [
                        'sku' => $item->sku,
                        'name' => $item->name,
                    ];
                }
            }



            if (empty($finalItemsList)) {
                return response()->json(['success' => false, 'message' => 'No se encontraron ítems válidos para generar etiquetas.'], 404);
            }

            $user = auth()->user();
            $companyId = $user->company_id;
            $company = Company::find($companyId);

            Log::info('datos de  barcode ::: ', ['data' => $company]);
            // 5. Llamar al servicio sin el argumento 'copies', ya que la lista está aplanada
            $pdfOutput = $this->barcodePdfService->generateBarcodes(
                $finalItemsList,
                $company
            );


            // 6. Devolver la respuesta
            return response($pdfOutput)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="Etiquetas_Codigos_Barras_' . date('Ymd_His') . '.pdf"');

        } catch (\Exception $e) {
            Log::error('Error generating barcode PDF: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor al generar el PDF.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
