<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('clients', function (Blueprint $table) {
        $table->unsignedBigInteger('branch_id')->nullable()->after('company_id');
        $table->string('branch_code')->nullable()->after('branch_id');
        $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('clients', function (Blueprint $table) {
        $table->dropForeign(['branch_id']);
        $table->dropColumn(['branch_id', 'branch_code']);
    });
}
};
