<?php

namespace App\Services;

use App\Models\PaymentProvider;

/**
 * Servicio encargado de gestionar la lógica de siembra (seeding)
 * de proveedores de pago por defecto para una compañía/sucursal específica.
 */
class PaymentProviderService
{
    /**
     * Lista de proveedores de pago estándar.
     *
     * @var array
     */
    protected $defaultProviders = [
        // --- 1. BANCOS PRINCIPALES ---
        ['name' => 'Efectivo', 'code' => 'EFECTIVO', 'is_active' => true],
        ['name' => 'Bancolombia', 'code' => 'BNC', 'is_active' => true],
        ['name' => 'Banco de Bogotá', 'code' => 'BDB', 'is_active' => true],
        ['name' => 'Davivienda', 'code' => 'DVB', 'is_active' => true],
        ['name' => 'BBVA Colombia', 'code' => 'BBV', 'is_active' => true],
        ['name' => 'Banco Popular', 'code' => 'BPP', 'is_active' => true],
        ['name' => 'Banco Caja Social', 'code' => 'BCS', 'is_active' => true],
        ['name' => 'Banco Pichincha', 'code' => 'BPC', 'is_active' => true],
        ['name' => 'Itaú Colombia', 'code' => 'ITA', 'is_active' => true],
        ['name' => 'Banco Agrario', 'code' => 'BAG', 'is_active' => true],
        ['name' => 'Banco Av Villas', 'code' => 'BAV', 'is_active' => true],

        // --- 2. PASARELAS DE PAGO Y E-WALLETS ---
        ['name' => 'PSE', 'code' => 'PSE', 'is_active' => true],
        ['name' => 'Nequi', 'code' => 'NEQ', 'is_active' => true],
        ['name' => 'Daviplata', 'code' => 'DVP', 'is_active' => true],
        ['name' => 'Tarjeta de Crédito (Visa/Mastercard)', 'code' => 'TDC', 'is_active' => true],
        ['name' => 'PayPal', 'code' => 'PPL', 'is_active' => true],
        ['name' => 'PayU', 'code' => 'PAYU', 'is_active' => true],
        ['name' => 'Mercado Pago', 'code' => 'MPGO', 'is_active' => true],
        ['name' => 'Wompi', 'code' => 'WMP', 'is_active' => true],

        // --- 3. FINANCIAMIENTO / CRÉDITO P.V. ---
        ['name' => 'Addi', 'code' => 'ADDI', 'is_active' => true],
        ['name' => 'Sistecrédito', 'code' => 'SISC', 'is_active' => true],

        // --- 4. MÉTODOS DE PAGO EN EFECTIVO TERCERIZADOS (Recaudo) ---
        ['name' => 'Efecty (Recaudo)', 'code' => 'EFT', 'is_active' => true],
        ['name' => 'Baloto (Recaudo)', 'code' => 'BLT', 'is_active' => true],
    ];

    /**
     * Siembra los proveedores de pago por defecto para una compañía y sucursal.
     *
     * @param int $companyId El ID de la compañía.
     * @param int $branchId El ID de la sucursal.
     * @return int El número de proveedores creados o actualizados.
     */
    public function seedDefaultProviders(int $companyId, int $branchId): int
    {
        $count = 0;

        foreach ($this->defaultProviders as $provider) {
            // Asegura que los datos de la compañía y sucursal se incluyan en el array de creación.
            $dataToCreate = array_merge($provider, [
                'company_id' => $companyId,
                'branch_id' => $branchId,
            ]);

            // Utiliza firstOrCreate para crear si no existe, o retornar la instancia si ya existe.
            PaymentProvider::firstOrCreate(
                [
                    // Criterios de búsqueda para evitar duplicados en la misma compañía/sucursal
                    'company_id' => $companyId,
                    'branch_id' => $branchId,
                    'code' => $provider['code'],
                    'accounts_receivable'=>$provider['code'] === 'EFECTIVO' ? 0:1,
                ],
                $dataToCreate // Datos a usar si se crea un nuevo registro
            );

            $count++;
        }

        return $count;
    }
}
