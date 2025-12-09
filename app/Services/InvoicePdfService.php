<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Models\Sale; // Asumiendo que pasarás la Venta como objeto

class InvoicePdfService
{
    /**
     * Genera la factura en formato PDF a partir de un objeto Sale.
     * * @param Sale $sale Objeto de la venta (debe cargarse con items, client, y company).
     * @return string El contenido binario del PDF.
     */
    public function generateInvoice(Sale $sale): string
    {
        // 1. Cargar las relaciones necesarias si no están ya cargadas
        $sale->loadMissing(['items', 'client', 'company', 'branch']);

        // 2. Datos para la plantilla
        $data = [
            'sale' => $sale,
            'company' => $sale->company,
            'branch' => $sale->branch,
            'client' => $sale->client,
            'saleItems' => $sale->items,
            'currentDate' => now()->format('Y-m-d H:i:s'),
        ];

        try {
            // 3. Renderizar la vista y generar el PDF
            $pdf = Pdf::loadView('pdf.invoice_template', $data);

            // 4. Devolver el contenido del PDF como una cadena binaria
            return $pdf->output();

        } catch (\Exception $e) {
            Log::error('Error generating invoice PDF: ' . $e->getMessage(), ['sale_id' => $sale->id]);
            // Opcional: lanzar una excepción o devolver un PDF de error
            throw new \RuntimeException('Error al generar el documento PDF.', 500);
        }
    }
}
