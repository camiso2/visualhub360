<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\CompanyRoleSetupController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DocumentsClientController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AccountReceivableController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//autocompletar codigo laravel
//composer require --dev barryvdh/laravel-ide-helper
//php artisan ide-helper:generate

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

//php artisan l5-swagger:generate
// php artisan migrate --path=/database/migrations/2025_10_29_143744_create_clients_table.php
// php artisan migrate:rollback --step=1
/*
-- Permisos heredados de roles
    SELECT p.name AS permiso, r.name AS fuente
    FROM permissions p
    JOIN role_has_permissions rp ON p.id = rp.permission_id
    JOIN roles r ON rp.role_id = r.id
    JOIN model_has_roles mr ON r.id = mr.role_id
    WHERE mr.model_id = 44 AND mr.model_type = 'App\\Models\\User'

    UNION

    -- Permisos asignados directamente al usuario
    SELECT p.name AS permiso, 'directo' AS fuente
    FROM permissions p
    JOIN model_has_permissions mp ON p.id = mp.permission_id
    WHERE mp.model_id = 44 AND mp.model_type = 'App\\Models\\User';
*/

Route::post('/registerCompany', [AuthController::class, 'registerCompany']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api', 'branch.active.api'])->group(function () {

    //ahutenticación
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);


    //permisos y roles
    Route::get('/roles', [RolePermissionController::class, 'getRoles']);
    Route::get('/permissions', [RolePermissionController::class, 'getPermissions']);
    //asignar roles a una empresa
    Route::post('/companies/{id}/roles/setup', [CompanyRoleSetupController::class, 'setup']);


    //Gestion de usuarios administracion
    Route::post('/admin/createUser', [AdminController::class, 'createUser'])->middleware('permission:crear usuarios');
    Route::post('/admin/users/{id}', [AdminController::class, 'updateUser'])->middleware('permission:editar usuarios');;
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser']);
    Route::patch('/admin/users/{user}/restore', [AdminController::class, 'restoreUser']);
    Route::get('/users', [AdminController::class, 'listUsers'])->middleware('permission:ver usuarios');
    Route::put('/admin/users/{userId}/permissions', [AdminController::class, 'updateUserPermissions']);
    Route::post('/admin/companies/{companyId}/roles', [AdminController::class, 'addRoleToCompany']);

    //cliente
    Route::get('/clients', [ClientController::class, 'index'])->middleware('permission:ver clientes');
    Route::post('/regiterClient', [ClientController::class, 'regiterClient'])->middleware('permission:crear clientes');/*->middleware('can:registrar clientes');*/ ;
    Route::post('/clients/update/{id}', [ClientController::class, 'updateClient'])->middleware('permission:editar clientes');
    Route::get('/clients/{id}', [ClientController::class, 'show']);
    Route::delete('/clients/{id}', [ClientController::class, 'destroy']);
    Route::get('/clients/trashed', [ClientController::class, 'trashed']);
    Route::post('/clients/{id}/restore', [ClientController::class, 'restore']);
        Route::post('/clients/searchByDocument', action: [ClientController::class, 'searchByDocument'])->middleware('permission:ver documentos');




    // Gestión de Sucursales - Administración
    Route::get('/branchess', [BranchController::class, 'listBranches'])->middleware('permission:ver sucursales');
    Route::post('/admin/branches', [BranchController::class, 'createBranch'])->middleware('permission:crear sucursales');          // Crear sucursal
    Route::post('/admin/branches/{id}', [BranchController::class, 'updateBranch'])->middleware('permission:editar sucursales');  // Actualizar sucursal
    Route::delete('/admin/branch/{id}', [BranchController::class, 'deleteBranch']); // Eliminar sucursal
    Route::post('/admin/branch/{branch}/restore', [BranchController::class, 'restoreBranch']); // Restaurar sucursal

    /*************************************************************************************** */
    //INVENTARIO X SUCURSAL

    Route::post('/admin/inventories', [InventoryController::class, 'createInventory'])->middleware('permission:crear inventarios');
    Route::post('/admin/inventories/{id}', [InventoryController::class, 'updateInventory']);
    Route::get('/inventories/branch', [InventoryController::class, 'getBranchInventories'])->middleware('permission:ver inventarios');// inventario por sucursal
    Route::get('/admin/inventories/branch/{branch_id}/sku/{sku}', [InventoryController::class, 'getInventoryBySku']);// inventario por sucursal u sku
    Route::get('/inventories/{branch}', [InventoryController::class, 'listInventories'])->middleware('permission:ver inventarios');
    Route::delete('/inventories/{id}', [InventoryController::class, 'destroy']);
    Route::post('/inventories/{id}/restore', [InventoryController::class, 'restore']);

    Route::post('/inventory/searchBySku', action: [InventoryController::class, 'searchBySku'])->middleware('permission:ver inventarios');


    // proveedores
    Route::post('/admin/suppliers', [SupplierController::class, 'createSupplier'])->middleware('permission:crear proveedores');
    Route::put('/admin/suppliers/{supplier}', [SupplierController::class, 'updateSupplier'])->middleware('permission:editar proveedores');;
    Route::delete('/admin/suppliers/{supplier}', [SupplierController::class, 'deleteSupplier']);
    Route::get('/suppliers', [SupplierController::class, 'listSuppliers'])->middleware('permission:ver proveedores');

    //Documentos de cliente
    Route::post('/documentsClient', [DocumentsClientController::class, 'createDocumentClient'])->middleware('permission:crear documentos');
    Route::get('/documentsClient/{client_id}/history', [DocumentsClientController::class, 'getClientDocumentsHistory'])->middleware('permission:ver documentos');;
    Route::delete('/admin/document-clients/{document_id}/image/{image_id}', [DocumentsClientController::class, 'deleteDocumentImage'])->middleware('permission:eliminar documentos');
    Route::post('/admin/document-clients/{document_id}', [DocumentsClientController::class, 'updateDocumentClient'])->middleware('permission:editar documentos');


    //venta de productos
    Route::post('/sales', [SaleController::class, 'createSale'])->middleware('permission:crear ventas');
    Route::get('/sales', [SaleController::class, 'listSales'])->middleware('permission:ver ventas');
    Route::post('/admin/sales/{sale_id}/cancel', [SaleController::class, 'cancelSale'])->middleware('permission:anular ventas');;

    // cuenta de cobro
    Route::get('/accountsReceivable', [AccountReceivableController::class, 'listAcountsReceivable'])->middleware('permission:ver cxc');
    Route::post('/admin/accountsReceivable/{accountReceivable}/pay', [AccountReceivableController::class, 'payReceivable']);

    //codigos de barras
    Route::post('/inventory/generateBarcodes', [BarcodeController::class, 'createInventoryBarcodes']);

    Route::get('/data/generalDashboard', [DashboardController::class, 'dataGeneralHeader'])->middleware('permission:datos generales');
    Route::get('/data/salesChartData', [DashboardController::class, 'salesChartDataByBranch'])->middleware('permission:datos generales');
    Route::get('/data/weeklyBranchSalesLineData', [DashboardController::class, 'weeklyBranchSalesLineData'])->middleware('permission:datos generales');
    Route::get('/data/productSalesDistribution', [DashboardController::class, 'productSalesDistribution'])->middleware('permission:datos generales');


});

