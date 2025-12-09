<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Custom\ApiResponseTrait;
use App\Models\Client;
use App\Models\Branch;
use App\Models\Inventory;
use App\Models\Sale;
use App\Models\User;
use App\Models\AccountReceivable;
use App\Models\SaleItem;
use Carbon\Carbon;



class DashboardController extends Controller
{
    use ApiResponseTrait;


    // ... (otras funciones y propiedades)

    /**
     * Función auxiliar para calcular el porcentaje de variación.
     */
    private function calculatePercentageChange($current, $previous): float
    {
        if ($previous == 0) {
            // Si el periodo anterior no tuvo ventas, y el actual sí, se considera un 100% de aumento.
            return $current > 0 ? 100.0 : 0.0;
        }

        // Fórmula: ((Actual - Anterior) / Anterior) * 100
        return round((($current - $previous) / $previous) * 100, 2);
    }

    /**
     * @OA\Get(
     * path="/api/data/generalDashboard",
     * summary="Obtener métricas clave del dashboard (Encabezado)",
     * description="Devuelve métricas en tiempo real para el usuario actual (sucursal): Valor de inventario, Cuentas por Cobrar Pendientes, Ventas Diarias/Mensuales y Artículo Más Vendido.",
     * tags={"Reportes y Dashboard"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Métricas obtenidas correctamente",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Datos generales del encabezado obtenidos correctamente"),
     * @OA\Property(property="data", type="object", description="Métricas calculadas para la sucursal del usuario.",
     * @OA\Property(property="branch", type="object", description="Detalles de la sucursal actual."),
     * * @OA\Property(property="current_inventory_value", type="number", format="float", example=150000.50, description="Valor total del inventario disponible (quantity - output_unit) a precio de venta."),
     * @OA\Property(property="pending_ar_count", type="integer", example=12, description="Número de cuentas por cobrar en estado 'pending'."),
     * @OA\Property(property="pending_ar_total_amount", type="number", format="float", example=8950.00, description="Valor total acumulado de las cuentas por cobrar pendientes."),
     * @OA\Property(property="active_branches_count", type="integer", example=5, description="Cantidad de sucursales activas en la compañía."),
     * @OA\Property(property="current_clients_count", type="integer", example=450, description="Cantidad total de clientes asociados a la sucursal actual."),
     * * @OA\Property(property="today_sales_amount", type="number", format="float", example=550.00, description="Ventas totales del día actual."),
     * @OA\Property(property="daily_change_percent", type="number", format="float", example=-15.00, description="Variación porcentual de ventas con respecto al día anterior."),
     * * @OA\Property(property="last_month_sales_amount", type="number", format="float", example=15500.50, description="Ventas totales del mes anterior."),
     * @OA\Property(property="sales_change_percent", type="number", format="float", example=24.00, description="Variación porcentual de ventas con respecto al mes anterior."),
     * * @OA\Property(property="best_selling_product", type="object", nullable=true, description="Detalles del artículo más vendido en la sucursal.",
     * @OA\Property(property="name", type="string", example="Gafas de sol"),
     * @OA\Property(property="sku", type="string", example="00028019000001"),
     * @OA\Property(property="quantity_sold", type="integer", example=75)
     * ),
     * )
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Token de autenticación faltante o inválido"
     * ),
     * @OA\Response(
     * response=500,
     * description="Error interno del servidor"
     * )
     * )
     */
    // ... (Tus otros uses)

    public function dataGeneralHeader()
    {
        $user = auth()->user();


        Log::info('datos de ventas ::: ' . Sale::where('branch_id', $user->branch->id)->get());
        Log::info('datos de inventarios ::: ' . Inventory::where('branch_id', $user->branch->id)->get());
        Log::info('datos de sale Items ::: ' . SaleItem::all());


        try {
            $branchId = $user->branch->id;

            // --- CÁLCULO DE ARTÍCULO MÁS VENDIDO (Sin cambios) ---
            $mostSoldItem = DB::table('sale_items')
                ->select('inventory_id', DB::raw('SUM(quantity) as total_quantity_sold'))
                ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                ->where('sales.branch_id', $branchId)
                ->where('sales.status', 'completed')
                ->groupBy('inventory_id')
                ->orderByDesc('total_quantity_sold')
                ->first();

            $bestSellingProduct = null;
            if ($mostSoldItem) {
                $productDetails = Inventory::where('id', $mostSoldItem->inventory_id)
                    ->select('name', 'sku')->first();
                if ($productDetails) {
                    $bestSellingProduct = [
                        'name' => $productDetails->name,
                        'sku' => $productDetails->sku,
                        'quantity_sold' => (int) $mostSoldItem->total_quantity_sold
                    ];
                }
            }

            // --- CÁLCULO DE CUENTAS POR COBRAR PENDIENTES (Sin cambios) ---
            $pendingAR = AccountReceivable::where('branch_id', $branchId)
                ->where('status', 'pending');

            $pendingARCount = $pendingAR->count();
            $pendingARTotalAmount = $pendingAR->sum('amount') ?? 0;

            // --- CÁLCULO DE CUENTAS POR COBRAR pagadas (Sin cambios) ---
            $paidPA = AccountReceivable::where('branch_id', $branchId)
                ->where('status', 'paid');

            $paidARCount = $paidPA->count();
            $paidARTotalAmount = $paidPA->sum('amount') ?? 0;

            // --- CÁLCULO DE VALOR DE INVENTARIO PVP(Sin cambios) ---
            $inventoryValue = Inventory::where('branch_id', $branchId)
                ->where('active', 1)
                ->sum(DB::raw('(quantity - output_unit) * sale_price')) ?? 0;

            // --- CÁLCULO DE VALOR DE INVENTARIO PNC (Sin cambios) ---
            $inventoryValuePurchasePrice = Inventory::where('branch_id', $branchId)
                ->where('active', 1)
                ->sum(DB::raw('(quantity - output_unit) * purchase_price')) ?? 0;

            // --- CÁLCULO DE SUCURSALES ACTIVAS (Sin cambios) ---
            $activeBranchesCount = Branch::where('company_id', $user->company_id)
                ->where('active', 1)
                ->count();

            // --- CÁLCULO DE CLIENTES DE LA SUCURSAL ACTUAL (Sin cambios) ---
            $currentClientsCount = Client::where('branch_id', $branchId)
                ->count();

            // --- CÁLCULO DE VENTAS DIARIAS (Sin cambios) ---
            $today = Carbon::today();
            $yesterday = Carbon::yesterday();

            $todaySalesTotal = Sale::where('branch_id', $branchId)
                ->whereBetween('sale_date', [$today->startOfDay(), Carbon::now()])
                ->where('status', 'completed')
                ->sum('grand_total') ?? 0;

            $yesterdaySalesTotal = Sale::where('branch_id', $branchId)
                ->whereBetween('sale_date', [$yesterday->startOfDay(), $yesterday->endOfDay()])
                ->where('status', 'completed')
                ->sum('grand_total') ?? 0;

            $dailyChangePercent = $this->calculatePercentageChange(
                $todaySalesTotal,
                $yesterdaySalesTotal
            );

            // --- CÁLCULO DE VENTAS MENSUALES (CORRECCIÓN IMPORTANTE AQUÍ) ---

            // 1. Período del Mes Actual (Desde el ultimos 30 díasinicio del mes hasta ahora)
            $startOfCurrentMonth = Carbon::now()->subDays(30)->startOfMonth();
            $endOfCurrentMonth = Carbon::now(); // Hoy

            // 2. Período del Mes Pasado Completo (Para comparación)
            $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
            $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
            // NUEVA MÉTRICA: Ventas del Mes Actual hasta hoy
            $currentMonthSalesTotal = Sale::where('branch_id', $branchId)
                ->whereBetween('sale_date', [$startOfCurrentMonth, $endOfCurrentMonth])
                ->where('status', 'completed')
                ->sum('grand_total') ?? 0;
            // Ventas del Mes Pasado Completo (Base de comparación)
            $lastMonthSalesTotal = Sale::where('branch_id', $branchId)
                ->whereBetween('sale_date', [$startOfLastMonth, $endOfLastMonth])
                ->where('status', 'completed')
                ->sum('grand_total') ?? 0;
            //CORRECCIÓN DEL CÁLCULO DE CAMBIO PORCENTUAL
            // Comparamos Mes Actual ($currentMonthSalesTotal) vs Mes Pasado ($lastMonthSalesTotal)
            $monthlyChangePercent = $this->calculatePercentageChange(
                $currentMonthSalesTotal,
                $lastMonthSalesTotal
            );
            //TOTAL  VENTAS ANULADAS
            // Fecha de inicio: hace 6 meses
            $startDate = Carbon::now()->subMonths(6)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
            // Ventas anuladas en los últimos 6 meses
            $canceledSalesTotal = Sale::withoutGlobalScopes()
                ->where('company_id', $user->company_id)
                ->where('branch_id', $user->branch_id)->whereBetween('sale_date', [$startDate, $endDate])
                ->where('status', 'canceled')
                ->sum('grand_total') ?? 0;



            //cantidad de  ventas  anuladas
            $canceledSalesCount = Sale::withoutGlobalScopes()
                ->where('company_id', $user->company_id)
                ->where('branch_id', $user->branch_id)
                ->whereBetween('sale_date', [$startDate, $endDate])
                ->where('status', 'canceled')
                ->count();

            //productos activos en sucursal
            $activeCountInventoty = Inventory::where('branch_id', $branchId)
                ->where('active', 1)
                ->count();

            //porcentaje de ganancia real promedio
            $avgRealMarginInventoty = Inventory::where('branch_id', $branchId)
                ->where('active', 1)
                ->where('purchase_price', '>', 0)
                // ⚠️ Filtra solo el inventario con existencias reales disponibles (quantity > output_unit)
                ->whereRaw('(quantity - output_unit) > 0')
                ->selectRaw("
        (
            SUM(
                -- 1. CALCULAR UTILIDAD NETA UNITARIA (Solo IVA)
                (
                    -- Ingreso Neto: Precio Venta Bruto / (1 + IVA/100)
                    (sale_price / (1 + tax_sale/100))

                    -- Restar el Costo Neto
                    - purchase_price
                )
                * (quantity - output_unit) -- PONDERACIÓN: Multiplicar por Existencias Reales
            )
        )
        /
        SUM(
            -- 2. CALCULAR COSTO TOTAL NETO PONDERADO (Denominador)
            purchase_price * (quantity - output_unit) -- PONDERACIÓN: Multiplicar por Existencias Reales
        )
        * 100
        as avg_markup_ponderado
    ")
                ->value('avg_markup_ponderado') ?? 0;


            // --- RESPUESTA CON MÉTRICAS ---
            return response()->json(
                $this->successfullMessage(
                    200,
                    'Datos generales del encabezado obtenidos correctamente',
                    true,
                    1,
                    [
                        'branch' => $user->branch,

                        'avg_real_margin_inventoty' => (int) $avgRealMarginInventoty,
                        'active_count_inventoty' => (int) $activeCountInventoty,


                        'canceled_sales_total' => (int) $canceledSalesTotal,
                        'canceled_sales_count' => (int) $canceledSalesCount,

                        'paid_ar_count' => (int) $paidARCount,
                        'paid_ar_total_amount' => (int) $paidARTotalAmount,
                        'best_selling_product' => $bestSellingProduct,
                        'pending_ar_count' => (int) $pendingARCount,
                        'pending_ar_total_amount' => (float) $pendingARTotalAmount,
                        'current_inventory_value' => (float) $inventoryValue,
                        'inventory_value_urchase_price' => (float) $inventoryValuePurchasePrice,
                        'active_branches_count' => (int) $activeBranchesCount,
                        'current_clients_count' => (int) $currentClientsCount,
                        'today_sales_amount' => (float) $todaySalesTotal,
                        'daily_change_percent' => $dailyChangePercent,

                        // 🛑 Corregimos el nombre de la métrica en la respuesta
                        'current_month_sales_amount' => (float) $currentMonthSalesTotal, // NUEVA MÉTRICA

                        // Mantenemos la base si la necesitas para otra cosa, pero ya no se usa para la tarjeta principal
                        'last_month_sales_amount' => (float) $lastMonthSalesTotal,
                        'sales_change_percent' => $monthlyChangePercent,
                        'last_month_gross_profit' => $this->getLastMonthProfit(
                            auth()->user()->branch_id
                        ),
                    ]
                ),
                200
            );

        } catch (\Exception $e) {
            // ... (Error handling)
            Log::error("Error al obtener datos generales del encabezado: " . $e->getMessage());
            return response()->json(
                $this->errorGeneric('Error al obtener datos generales del encabezado: ' . $e->getMessage(), 500),
                500
            );
        }
    }

public function getLastMonthProfit($branchId)

    {

        try {

            // Inicio del mes actual

            $start = Carbon::now()->subDays(30)->startOfMonth();
            // Fin del día de hoy
            $end = Carbon::now()->endOfDay();
            // Ventas brutas, descuentos e impuestos
            $sales = DB::table('sale_items as si')
                ->join('sales as s', 's.id', '=', 'si.sale_id')
                ->where('s.branch_id', $branchId)
                ->whereBetween('si.created_at', [$start, $end])
                ->selectRaw("
                SUM(si.line_total) as gross_sales,
                SUM(si.discount_applied) as total_discounts,
                SUM(si.line_total - (si.line_total / (1 + si.tax_rate/100))) as total_taxes
            ")
             ->first();
             Log::info('datos de  sales ::: ', ['sales ::' => $sales]);

            // Costo de ventas (cantidad × precio de compra)
            $cost = DB::table('sale_items as si')
                ->join('sales as s', 's.id', '=', 'si.sale_id')
                ->join('inventories as i', 'i.id', '=', 'si.inventory_id')
                ->where('s.branch_id', $branchId)
                ->whereBetween('si.created_at', [$start, $end])
                ->selectRaw("SUM(si.quantity * i.purchase_price) as cost_of_goods")
                ->first();

                Log::info('datos de  cost sale_items ::: ', ['cost ::' => $cost]);

            $netSales = $sales->gross_sales - $sales->total_taxes;
            // Porcentaje de descuento sobre ventas netas
            $discountPercent = $netSales > 0
                ? round(($sales->total_discounts / $netSales) * 100, 2)
                : 0;
            $grossProfit = $netSales - ($cost->cost_of_goods ?? 0);
            $netProfit = $grossProfit - $sales->total_discounts;

            return [
                'branch_id' => $branchId,
                'sales_net' => round($netSales, 2),
                'cost_sales' => round($cost->cost_of_goods ?? 0, 2),
                'discount' => round($sales->total_discounts, 2),
                'discount_percent' => $discountPercent,
                'tax' => round($sales->total_taxes, 2),
                'utility_bruta' => round($grossProfit, 2),
                'utility_net' => round($netProfit, 2),
                'period' => $start->format('Y-m-d') . ' to ' . $end->format('Y-m-d'),
            ];



        } catch (\Exception $e) {

            Log::error("Error calculating profit: " . $e->getMessage());

            return ['error' => 'Could not calculate profit'];

        }

    }




    /**
     * @OA\Get(
     * path="/api/data/salesChartData",
     * summary="Obtener datos para el gráfico de ventas por sucursal (Últimos 6 meses)",
     * description="Devuelve los 'labels' y 'datasets' de ventas totales por sucursal para las últimas 6 meses de la compañía del usuario autenticado.",
     * tags={"Reportes y Dashboard"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Datos del gráfico obtenidos correctamente",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Datos del gráfico de ventas obtenidos correctamente"),
     * @OA\Property(property="data", type="object", description="Estructura de datos para el gráfico.",
     * @OA\Property(property="labels", type="array", @OA\Items(type="string", example="Mar"), description="Etiquetas de los últimos 6 meses."),
     * **@OA\Property(property="datasets", type="array", description="Series de datos (una por sucursal).",**
     * **@OA\Items(**
     * **@OA\Property(property="label", type="string", example="Ventas de Sucursal A ($)"),**
     * **@OA\Property(property="backgroundColor", type="string", example="#4f46e5"),**
     * **@OA\Property(property="borderRadius", type="integer", example=4),**
     * **@OA\Property(property="data", type="array", @OA\Items(type="number", format="float", example=7500.00), description="Array de 6 valores de venta por mes.")**
     * **)**
     * **),**
     * ),
     * ),
     * ),
     * @OA\Response(response=401, description="Token inválido"),
     * @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function salesChartDataByBranch(): JsonResponse
    {
        $user = auth()->user();

        try {
            $companyId = $user->company_id;
            $monthsCount = 6;

            // 1. Obtener todas las sucursales activas de la compañía
            $allBranches = Branch::where('company_id', $companyId)
                ->select('id', 'name')
                ->where('active', 1)
                ->get();

            $branchDatasets = [];
            $chartLabels = [];

            // Generar etiquetas (Labels) para los últimos 6 meses (Ene, Feb, Mar, etc.)
            for ($i = $monthsCount - 1; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                // Usamos isoFormat para obtener la abreviatura de mes en el idioma local
                $chartLabels[] = $month->isoFormat('MMM');
            }

            // 2. Iterar sobre cada sucursal para obtener sus ventas mensuales
            foreach ($allBranches as $branch) {
                $monthlySalesData = [];

                // Iteramos sobre los últimos 6 meses (i=0 es el mes actual)
                for ($i = $monthsCount - 1; $i >= 0; $i--) {

                    // 🛑 CLONAR: Crear una copia para evitar modificar el objeto 'month' original
                    $currentMonth = Carbon::now()->subMonths($i);

                    $start = $currentMonth->copy()->startOfMonth();

                    // CORRECCIÓN CLAVE: Definir correctamente el punto final del rango
                    if ($i === 0) {
                        // Si $i es 0 (mes actual), el final es la fecha y hora de AHORA
                        $end = Carbon::now();
                    } else {
                        // Si es un mes pasado, el final es el final de ese mes (23:59:59)
                        // Se usa $currentMonth (la copia del mes original)
                        $end = $currentMonth->copy()->endOfMonth();
                    }

                    // Consultar las ventas completeds para ese mes y sucursal
                    $totalSale = Sale::withoutGlobalScopes()
                        ->where('branch_id', $branch->id)
                        ->whereBetween('sale_date', [$start, $end]) // EL RANGO AHORA ES CORRECTO
                        ->where('status', 'completed')
                        ->sum('grand_total') ?? 0;

                    $monthlySalesData[] = (float) $totalSale;
                }
                // 3. Construir el dataset para esta sucursal
                $branchDatasets[] = [
                    'label' => 'Ventas de ' . $branch->name,
                    'backgroundColor' => $this->getBranchColor($branch->id),
                    'borderRadius' => 4,
                    'data' => $monthlySalesData,
                ];
            }

            // 4. Construir el objeto final del gráfico
            $salesChartData = [
                'labels' => $chartLabels,
                'datasets' => $branchDatasets,
            ];

            // --- RESPUESTA FINAL ---
            return response()->json(
                $this->successfullMessage(
                    201,
                    'Datos del gráfico de ventas obtenidos correctamente',
                    true,
                    1,
                    $salesChartData // <-- Devuelve SOLAMENTE la estructura de datos del gráfico
                ),
                201
            );

        } catch (\Exception $e) {
            Log::error("Error al obtener datos del gráfico de ventas: " . $e->getMessage());
            return response()->json(
                $this->errorGeneric('Error al obtener datos del gráfico de ventas: ' . $e->getMessage(), 500),
                500
            );
        }
    }
    /**
     * @OA\Get(
     * path="/api/data/weeklyBranchSalesLineData",
     * summary="Obtener datos para el gráfico de tendencia de ventas por sucursal (Última semana)",
     * description="Devuelve los 'labels' y 'datasets' de ventas totales por sucursal para los últimos 7 días, ideal para un gráfico de línea multilínea.",
     * tags={"Reportes y Dashboard"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=201,
     * description="Datos del gráfico de tendencia de ventas obtenidos correctamente",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Datos del gráfico de tendencia de ventas por sucursal obtenidos correctamente"),
     * @OA\Property(property="data", type="object", description="Estructura de datos para el gráfico.",
     * @OA\Property(property="labels", type="array", @OA\Items(type="string", example="Lun"), description="Etiquetas de los últimos 7 días."),
     * @OA\Property(property="datasets", type="array", description="Series de datos (una por sucursal).",
     * @OA\Items(
     * @OA\Property(property="label", type="string", example="Ventas de Sucursal Centro ($)"),
     * @OA\Property(property="borderColor", type="string", example="#2563EB"),
     * @OA\Property(property="tension", type="number", format="float", example=0.4),
     * @OA\Property(property="fill", type="boolean", example=false),
     * @OA\Property(property="data", type="array", @OA\Items(type="number", format="float", example=350.50), description="Array de 7 valores de venta por día."),
     * @OA\Property(property="type", type="string", example="line")
     * )
     * )
     * )
     * )
     * ),
     * @OA\Response(response=401, description="Token inválido"),
     * @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function weeklyBranchSalesLineData(): JsonResponse
    {
        $user = auth()->user();

        try {
            $companyId = $user->company_id;

            Carbon::setLocale('es');

            // 1. INICIO DE LA SEMANA → LUNES
            $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);

            // 2. Generar los 7 días ordenados Lunes → Domingo
            $days = [];
            $chartLabels = [];

            for ($i = 0; $i < 7; $i++) {
                $day = $startOfWeek->copy()->addDays($i);
                $days[] = $day;
                $chartLabels[] = $day->isoFormat('ddd'); // Lun, Mar, Mié...
            }

            // 3. Obtener todas las sucursales activas
            $allBranches = Branch::where('company_id', $companyId)
                ->where('active', 1)
                ->select('id', 'name')
                ->get();

            $branchDatasets = [];

            // 4. Por cada sucursal, generar dataset de ventas
            foreach ($allBranches as $branch) {

                $dailySalesData = [];
                $color = $this->getBranchColor($branch->id);

                foreach ($days as $day) {
                    // Ventas de ese día en esa sucursal
                    $totalSale = Sale::withoutGlobalScopes()
                        ->where('branch_id', $branch->id)
                        ->whereDate('sale_date', $day)
                        ->where('status', 'completed')
                        ->sum('grand_total') ?? 0;

                    $dailySalesData[] = (float) $totalSale;
                }

                // Dataset para Chart.js
                $branchDatasets[] = [
                    'label' => 'Ventas de ' . $branch->name,
                    'type' => 'line',
                    'borderColor' => $color,
                    'backgroundColor' => $color . '33',
                    'pointBackgroundColor' => $color,
                    'tension' => 0.4,
                    'fill' => false,
                    'data' => $dailySalesData,
                ];
            }

            // 5. Respuesta final
            $salesChartData = [
                'labels' => $chartLabels,      // Siempre Lun → Dom
                'datasets' => $branchDatasets, // Lineas por sucursal
            ];

            return response()->json(
                $this->successfullMessage(
                    201,
                    'Datos del gráfico de tendencia de ventas por sucursal obtenidos correctamente',
                    true,
                    1,
                    $salesChartData
                ),
                201
            );

        } catch (\Exception $e) {
            Log::error("Error al obtener datos del gráfico de tendencia de ventas: " . $e->getMessage());
            return response()->json(
                $this->errorGeneric('Error al obtener datos del gráfico de tendencia de ventas: ' . $e->getMessage(), 500),
                500
            );
        }
    }



    /**
     * @OA\Get(
     * path="/api/data/productSalesDistribution",
     * summary="Obtener datos para el gráfico de distribución de ventas por artículo (Doughnut)",
     * description="Devuelve los 'labels' y 'datasets' de las ventas totales agrupadas por artículo (Top 10), ideal para un gráfico de Donut o Tarta.",
     * tags={"Reportes y Dashboard"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=201,
     * description="Distribución de ventas por artículo obtenida correctamente",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Distribución de ventas por artículo obtenida correctamente"),
     * @OA\Property(property="data", type="object", description="Estructura de datos para el gráfico.",
     * @OA\Property(property="labels", type="array", @OA\Items(type="string", example="Camisa de Algodón"), description="Nombres de los artículos más vendidos."),
     * @OA\Property(property="datasets", type="array", description="Un único dataset con los valores de venta.",
     * @OA\Items(
     * @OA\Property(property="label", type="string", example="Monto de Ventas"),
     * @OA\Property(property="data", type="array", @OA\Items(type="number", format="float", example=1500.75), description="Array de valores de venta total por artículo."),
     * @OA\Property(property="backgroundColor", type="array", @OA\Items(type="string", example="#2563EB"), description="Colores para las secciones del Donut."),
     * @OA\Property(property="hoverOffset", type="integer", example=4)
     * )
     * )
     * )
     * )
     * ),
     * @OA\Response(response=401, description="Token inválido"),
     * @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function productSalesDistribution(): JsonResponse
    {
        $user = auth()->user();

        try {
            $companyId = $user->company_id;

            // OBTENER ID DE LA SUCURSAL DEL USUARIO AUTENTICADO
            $branchId = $user->branch_id;

            // 1. Calcular las ventas totales por producto.
            $productSales = SaleItem::query()
                ->select(
                    'inventories.name as item_name',
                    DB::raw('SUM(sale_items.quantity * sale_items.unit_price) as total_sold_amount')
                )
                // Unir con la tabla 'sales' para filtrar
                ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                // Unir con la tabla 'inventories' para obtener el nombre
                ->join('inventories', 'sale_items.inventory_id', '=', 'inventories.id')

                ->where('sales.company_id', $companyId)
                ->where('sales.status', 'completed')

                // FILTRO CLAVE: Limitar las ventas a la sucursal del usuario
                ->where('sales.branch_id', $branchId)

                ->groupBy('inventories.name')
                ->orderByDesc('total_sold_amount')
                ->limit(10)
                ->get();

            $chartLabels = [];
            $dataValues = [];
            $backgroundColors = [];

            // ... (El resto de la lógica para asignar colores y formar el dataset es el mismo)

            $colorIndex = 0;
            $colors = $this->getBranchColors();

            foreach ($productSales as $product) {
                $chartLabels[] = 'Producto: ' . $product->item_name;
                $dataValues[] = (float) $product->total_sold_amount;

                // Aquí es donde obtendrías el color si tuvieras el ID del producto: $this->getItemColor($product->inventory_id);
                // Si no, usamos el índice de color rotativo como lo tienes actualmente
                $backgroundColors[] = $colors[$colorIndex % count($colors)];
                $colorIndex++;
            }

            // 3. Estructurar el Dataset de Donut
            $doughnutData = [
                'labels' => $chartLabels,
                'datasets' => [
                    [
                        'label' => 'Monto de Ventas',
                        'data' => $dataValues,
                        'backgroundColor' => $backgroundColors,
                        'hoverOffset' => 4,
                    ]
                ],
            ];

            // 4. Respuesta final
            return response()->json(
                $this->successfullMessage(
                    201,
                    'Distribución de ventas por artículo obtenida correctamente para la sucursal del usuario',
                    true,
                    1,
                    $doughnutData
                ),
                201
            );

        } catch (\Exception $e) {
            Log::error("Error al obtener distribución de ventas por artículo: " . $e->getMessage());
            return response()->json(
                $this->errorGeneric('Error al obtener distribución de ventas por artículo: ' . $e->getMessage(), 500),
                500
            );
        }
    }



    /**
     * Función auxiliar para asignar colores consistentes a las sucursales en el gráfico.
     * * @param int $branchId
     * @return string
     */
    protected function getBranchColor(int $branchId): string
    {
        // Lista de colores para rotar
        $colors = $this->getBranchColors();/*[
'#2563EB', // Azul Corporativo Intenso (blue-600)
'#1E40AF', // Azul Profesional Oscuro (blue-800)
'#0EA5E9', // Cian Ejecutivo (sky-500)
'#14B8A6', // Verde Turquesa Moderno (teal-500)
'#10B981', // Verde Corporativo (emerald-500)
'#22C55E', // Verde Éxito Vibrante (green-500)
'#65A30D', // Verde Oliva Moderno (lime-600)
'#CA8A04', // Amarillo Dorado Intenso (yellow-600)
'#D97706', // Naranja Profesional (amber-600)
'#EA580C', // Naranja Profundo Ejecutivo (orange-600)
'#DB2777', // Rosa Ejecutivo (pink-600)
'#A855F7', // Morado Corporativo (purple-500)
'#7C3AED', // Violeta Intenso (indigo-600)
'#475569', // Gris Elegante (slate-600)
'#334155', // Gris Corporativo Oscuro (slate-700)
]
;*/


        // Usa el módulo (%) del ID de la sucursal por la cantidad de colores
        // Esto asegura que cada sucursal obtenga un color y que se reciclen si hay más de 8 sucursales.
        return $colors[($branchId % count($colors))];
    }


    /**
     * Función auxiliar para obtener la lista de colores (asume que existe o usa la versión anterior)
     */
    protected function getBranchColors(): array
    {
        return [
            '#2563EB',
            '#1E40AF',
            '#0EA5E9',
            '#14B8A6',
            '#10B981',
            '#22C55E',
            '#65A30D',
            '#CA8A04',
            '#D97706',
            '#EA580C',
            '#DB2777',
            '#A855F7',
            '#7C3AED',
            '#475569',
            '#334155',
        ];
    }



}
