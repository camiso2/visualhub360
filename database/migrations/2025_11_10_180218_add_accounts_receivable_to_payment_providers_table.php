<?php

// database/migrations/..._add_accounts_receivable_to_payment_providers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_providers', function (Blueprint $table) {
            // Valor por defecto 0 (false). Solo los proveedores de crédito serán 1.
            $table->boolean('accounts_receivable')->default(0)->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('payment_providers', function (Blueprint $table) {
            $table->dropColumn('accounts_receivable');
        });
    }
};
