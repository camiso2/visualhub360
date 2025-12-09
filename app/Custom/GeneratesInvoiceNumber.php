<?php

namespace App\Custom;

use App\Models\Sale; // Asegúrate de importar el modelo Sale
use Illuminate\Support\Facades\Log;

trait GeneratesInvoiceNumber
{
    /**
     * Obtiene el último número de factura para la sucursal actual,
     * y retorna el siguiente número consecutivo (incrementado y formateado).
     * * @param \App\Models\User $user El usuario autenticado (con company_id y branch_id).
     * @return string El siguiente número de factura formateado (ej: '00000002').
     */
    public function getNextInvoiceNumber($user): string
    {
        // 1. Obtener la última venta de la compañía y sucursal.
        // Se usa latest() para asegurar que es el más reciente.
        $lastSale = Sale::withoutGlobalScopes()
            ->where('company_id', $user->company_id)
            ->where('branch_id', $user->branch_id)
            ->latest() // Ordena por created_at DESC
            ->first();

        // Log::info('Last Sale found: ' . ($lastSale ? $lastSale->invoice_number : 'No sales found'));

        // 2. Definir el número de factura por defecto (si no hay ventas).
        $nextInvoiceNumber = '00000001';

        // 3. Verificar si existe la última venta y si tiene un invoice_number.
        if ($lastSale && $lastSale->invoice_number) {

            // a. Extraer la parte numérica del invoice_number
            // Esto asume que el invoice_number es solo la parte numérica o que
            // el número está al inicio y puede ser casteado directamente a int.
            $numericPart = (int) $lastSale->invoice_number;

            // b. Incrementar el número.
            $newInvoiceNumber = $numericPart ;//+ 1; //

            // c. Formatear con ceros a la izquierda (asumiendo 8 dígitos de largo).
            $nextInvoiceNumber = str_pad($newInvoiceNumber, 8, '0', STR_PAD_LEFT);
        }

        return $nextInvoiceNumber;
    }
}
