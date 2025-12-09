<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentProvider; // Asegúrate de importar tu modelo

class PaymentProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // IDs BASE SOLICITADOS
        $companyId = 27;
        $branchId = 16;

        $providers = [
            // --- 1. BANCOS PRINCIPALES ---
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

            // --- 3. FINANCIAMIENTO / CRÉDITO P.V. (Entradas Separadas) ---

            ['name' => 'Addi', 'code' => 'ADDI', 'is_active' => true], // ¡SEPARADO!
            ['name' => 'Sistecrédito', 'code' => 'SISC', 'is_active' => true], // ¡SEPARADO Y CON CÓDIGO PROPIO!

            // --- 4. MÉTODOS DE PAGO EN EFECTIVO TERCERIZADOS (Recaudo) ---

            ['name' => 'Efecty (Recaudo)', 'code' => 'EFT', 'is_active' => true],
            ['name' => 'Baloto (Recaudo)', 'code' => 'BLT', 'is_active' => true],
        ];

        foreach ($providers as $provider) {
            // Se utiliza firstOrCreate para prevenir duplicados.
            PaymentProvider::firstOrCreate(
                [
                    'company_id' => $companyId,
                    'branch_id' => $branchId,
                    'code' => $provider['code']
                ],
                $provider
            );
        }

    }
}
