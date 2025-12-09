<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
// Usamos la librería que sabemos que funciona para generar PNG
use Picqer\Barcode\BarcodeGeneratorPNG;

class BarcodePdfService
{
    /**
     * Genera un PDF de códigos de barras incrustando la imagen PNG via Base64.
     *
     * @param array $inventoryItems Array de ítems (con 'sku' y 'name').
     * @param int $copies Número de copias.
     * @return string Contenido binario del PDF.
     */
    public function generateBarcodes(array $inventoryItems, $company, int $copies = 1): string
    {
        $barcodes = [];
        $generator = new BarcodeGeneratorPNG();

        $barcodeHeight = 50;
        $barcodeType = BarcodeGeneratorPNG::TYPE_CODE_128;
        $pixelSize = 1;

        // 1. Generar la lista de etiquetas con el Base64
        foreach ($inventoryItems as $item) {
            if (empty($item['sku'])) { continue; }

            try {
                // Generar el contenido BINARIO del PNG
                $barcodeBinary = $generator->getBarcode($item['sku'], $barcodeType, $pixelSize, $barcodeHeight);

                // Codificar el binario a Base64 y añadir el prefijo de datos
                $barcodeBase64 = base64_encode($barcodeBinary);
                $barcodeImageTag = 'data:image/png;base64,' . $barcodeBase64;

                // Crear las copias
                for ($i = 0; $i < $copies; $i++) {
                    $barcodes[] = [
                        'sku' => $item['sku'],
                        'name' => $item['name'],
                        'barcode_base64_src' => $barcodeImageTag, // <--- Usamos esta variable en la vista
                    ];
                }
            } catch (\Exception $e) {
                Log::error('Barcode PNG generation failed for SKU ' . $item['sku'] . ': ' . $e->getMessage());
                continue;
            }
        }

        // 2. Renderizar la vista y generar el PDF
        try {
            $pdf = Pdf::loadView('pdf.barcode_labels', ['barcodes' => $barcodes,'company'=>$company]);
            $pdf->setPaper('A4', 'portrait');

            return $pdf->output();

        } catch (\Exception $e) {
            Log::error('DOMPDF rendering failed for barcodes: ' . $e->getMessage());
            // Lanzar excepción para que el controlador la capture
            throw new \RuntimeException('Error al generar el documento PDF.', 500);
        }
    }
}
