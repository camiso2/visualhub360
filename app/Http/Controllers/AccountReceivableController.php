<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Custom\ApiResponseTrait;
use App\Custom\HasCompanyScope;
use App\Scopes\CompanyScope;
use App\Models\User;
use App\Models\Role;
use App\Models\AccountReceivable;
use Carbon\Carbon;



use Illuminate\Support\Facades\Log;

class AccountReceivableController extends Controller
{

    use ApiResponseTrait, HasCompanyScope;

    /**
     * @OA\Get(
     * path="/api/accountsReceivable",
     * summary="Listar Cuentas por Cobrar filtradas por compañía y sucursal",
     * tags={"Cuentas por Cobrar"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="status", in="query", required=false, @OA\Schema(type="string", enum={"pending", "billed", "paid", "canceled"}, example="pending")),
     * @OA\Response(response=200, description="Lista de Cuentas por Cobrar")
     * )
     */
    public function listAcountsReceivable(Request $request)
    {
        // 1. Obtener el usuario autenticado (se usará en el catch y para logueo)
        $user = auth()->user();

        // 2. Definir Paginación
        $perPage = $request->get('per_page', 10); // Valor por defecto: 10

        try {
            // 3. Consulta Base
            // El AccountReceivable::query() YA aplica los Global Scopes (CompanyScope y BranchScope)
            $query = AccountReceivable::query();

            // 4. Carga de Relaciones (Eager Loading)
            $query->with(['sale', 'paymentProvider', 'client']);

            // 5. Filtros Opcionales

            // Filtro por Estado ('pending', 'paid', etc.)
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            // Filtro de Búsqueda (Implementación de búsqueda parcial si fuera necesario, usando las relaciones)
            if ($request->has('search')) {
                $searchTerm = '%' . $request->search . '%';
                $query->where(function ($q) use ($searchTerm) {
                    // Buscar por ID de la cuenta por cobrar
                    $q->where('id', 'like', $searchTerm)

                        // Buscar por datos de la Venta relacionada (Ej: invoice_number)
                        ->orWhereHas('sale', function ($saleQuery) use ($searchTerm) {
                            $saleQuery->where('invoice_number', 'like', $searchTerm);
                        })

                        // Buscar por datos del Cliente relacionado (Ej: nombre o número de documento)
                        ->orWhereHas('client', function ($clientQuery) use ($searchTerm) {
                            $clientQuery->where('name', 'like', $searchTerm)
                                ->orWhere('document_number', 'like', $searchTerm);
                        })
                        //Tipo de Pago (Proveedor de Pago)
                        ->orWhereHas('paymentProvider', function ($providerQuery) use ($searchTerm) {
                            // Asumo que la columna con el nombre es 'name'
                            $providerQuery->where('name', 'like', $searchTerm);
                        });
                });
            }

            // 6. Ordenar (Por defecto, por la más reciente)
            // Se mantiene 'latest()' o se usa explícitamente:
            /*$query->latest('created_at');*/
            $query->orderBy('created_at', 'desc');

            // 7. Ejecutar la consulta con Paginación
            $receivables = $query->paginate($perPage);

            // 8. Respuesta Exitosa
            return response()->json(
                $this->successfullMessage(
                    200,
                    'Cuentas por cobrar listadas exitosamente.',
                    true,
                    $receivables->total(), // Conteo total
                    ['receivables' => $receivables] // La colección paginada
                ),
                200
            );

        } catch (\Exception $e) {
            // Manejo de errores
            Log::error('Error al listar cuentas por cobrar (listAcountsReceivable): ' . $e->getMessage(), ['user_id' => $user->id]);
            return response()->json(
                $this->errorGeneric('Error interno al listar cuentas por cobrar.', 500),
                500
            );
        }
    }
    /**
     * @OA\Post(
     * path="/api/admin/accountsReceivable/{accountReceivable}/pay",
     * summary="Registrar el pago recibido de un proveedor de crédito (liquidación)",
     * description="Actualiza el estado a 'paid' y calcula la comisión y días transcurridos.",
     * tags={"Cuentas por Cobrar"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="accountReceivable", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="paid_amount", type="number", format="float", example=650000, description="Monto real recibido por su empresa del proveedor."),
     * )
     * ),
     * @OA\Response(response=200, description="Cuenta por Cobrar liquidada exitosamente")
     * )
     */
    public function payReceivable(Request $request, AccountReceivable $accountReceivable)
    {
        // 1. VALIDACIÓN
        $request->validate([
            'paid_amount' => 'required|numeric|min:0',
        ]);

        // 2. PRE-CHEQUEOS (Mantenemos la lógica de chequeo de estado)
        if ($accountReceivable->status == 'paid') {
            return response()->json(
                $this->errorMessage(
                    409,
                    'Esta cuenta ya fue liquidada.',
                    [
                        'status' => $accountReceivable->status,
                    ]
                ),
                409
            );
        }
        // --- NUEVA VALIDACIÓN: No permitir pagos superiores al monto total

        $amountDue = $accountReceivable->amount; // Monto total de la venta
        $paidAmount = $request->paid_amount;     // Monto recibido por tu empresa

        if ($paidAmount > $amountDue) {
            return response()->json(
                $this->errorMessage(
                    400, // 400 Bad Request o 422 Unprocessable Entity es apropiado aquí
                    'El monto pagado (' . number_format($paidAmount, 2) . ') no puede ser mayor que el monto total de la cuenta por cobrar (' . number_format($amountDue, 2) . ').',
                    [
                        'monto_total' => $amountDue,
                        'monto_pagado' => $paidAmount,
                    ]
                ),
                400
            );
        }

        if ($accountReceivable->status == 'canceled') {
            return response()->json(
                $this->errorMessage(
                    409,
                    'Esta cuenta está anulada.',
                    [
                        'status' => $accountReceivable->status,
                    ]
                ),
                409
            );
        }

        // El Global Scope ya asegura que la cuenta pertenezca al usuario.

        // 3. CÁLCULO DE LIQUIDACIÓN Y ESTADÍSTICAS
        $amountDue = $accountReceivable->amount; // Monto total de la venta
        $paidAmount = $request->paid_amount;     // Monto recibido por tu empresa

        // 🎯 CLAVE: Asignamos la fecha de pago al momento actual (now())
        $paidDate = Carbon::now();

        // ⚠️ Importante: Es necesario asegurar que $accountReceivable->sale->sale_date sea un objeto Carbon
        // Si usas $casts en el modelo Sale para 'sale_date', esto ya debería ser un objeto Carbon.
        $saleDate = $accountReceivable->sale->sale_date;

        // ⚠️ Si 'sale_date' NO es un objeto Carbon (ej. es un string), debes convertirlo:
        // $saleDate = Carbon::parse($accountReceivable->sale->sale_date);

        // Calcular Comisión
        $commissionAmount = $amountDue - $paidAmount;
        // Si amountDue es 0, evitamos división por cero.
        $commissionPercentage = ($amountDue > 0) ? ($commissionAmount / $amountDue) * 100 : 0;

        // Calcular Días Transcurridos
        $daysElapsed = $saleDate->diffInDays($paidDate);

        // 4. ACTUALIZAR EL REGISTRO
        $accountReceivable->paid_amount = $paidAmount;
        $accountReceivable->status = 'paid';
        // 🎯 CLAVE: Asignamos el objeto Carbon 'paidDate' al modelo antes de guardar
        $accountReceivable->paid_date = $paidDate;
        $accountReceivable->save();

        // 5. REGISTRAR LOG Y RESPUESTA
        Log::info('Liquidación de Cuenta por Cobrar', [
            'receivable_id' => $accountReceivable->id,
            'amount_due' => $amountDue,
            'paid_amount' => $paidAmount,
            'commission_percent' => number_format($commissionPercentage, 2) . '%',
            'days_elapsed' => $daysElapsed,
            'paid_by_user' => auth()->id()
        ]);

        return response()->json($this->successfullMessage(
            200,
            'Cuenta por Cobrar liquidada exitosamente. Se calculó la comisión y los días transcurridos.',
            true,
            1,
            [
                'account_receivable' => $accountReceivable,
                'summary' => [
                    'monto_total_venta' => $amountDue,
                    'monto_recibido' => $paidAmount,
                    'comision_porcentaje' => number_format($commissionPercentage, 2) . '%',
                    'dias_transcurridos_pago' => $daysElapsed . ' días',
                ]
            ]
        ));
    }
}
