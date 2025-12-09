<?php

namespace App\Services;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Company;

class RolePermissionService
{
    public function initializeForCompany(Company $company)
    {
        // 1. Roles base del sistema
        $roles = [
            ['name' => 'Administrador General', 'description' => 'Administra toda la empresa y sucursales'],
            ['name' => 'Administrador Sucursal', 'description' => 'Administra una sucursal específica'],
            ['name' => 'Supervisor', 'description' => 'Supervisa operaciones y personal'],
            ['name' => 'Asesor Interno', 'description' => 'Gestiona ventas y atención al cliente desde la empresa'],
            ['name' => 'Asesor Externo', 'description' => 'Gestiona ventas de campo o externas'],
            ['name' => 'Auditor', 'description' => 'Revisa procesos y operaciones'],
            ['name' => 'Cliente', 'description' => 'Accede a sus transacciones, reservas y pagos'],
        ];

        // 2. Permisos base globales del ERP
        $permissions = [

            'datos generales',
            // Usuarios
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',

            // Usuarios
            'ver sucursales',
            'crear sucursales',
            'editar sucursales',
            'eliminar sucursales',

            // Roles y permisos
            'ver roles',
            'crear roles',
            'editar roles',
            'eliminar roles',

            // Productos
            'ver productos',
            'crear productos',
            'editar productos',
            'eliminar productos',


            //proveedores
            'ver proveedores',
            'crear proveedor',
            'editar proveedor',
            'eliminar proveedor',

            //innventario
            'ver inventario',
            'crear inventario',
            'editar inventario',
            'movimientos inventario',

            // Ventas y
            'ver ventas',
            'crear ventas',
            'editar ventas',
            'anular ventas',

            //transacciones
            'ver transacciones',

            // Planes de reserva
            'ver planes',
            'crear planes',
            'editar planes',
            'eliminar planes',

            // Pagos
            'ver pagos',
            'registrar pagos',
            'editar pagos',
            'eliminar pagos',

            // Clientes
            'ver clientes',
            'crear clientes',
            'editar clientes',
            'eliminar clientes',


            // Documentos
            'ver documentos',
            'crear documentos',
            'editar documentos',
            'eliminar documentos',

            // Reportes
            'ver reportes',


            // Configuración
            'configurar empresa',
            'configurar sucursales'
        ];

        // 3. Crear permisos si no existen
        foreach ($permissions as $permName) {
            Permission::firstOrCreate([
                'name' => $permName,
                'guard_name' => 'api',
                'company_id' => $company->id
            ]);
        }

        // 4. Mapa de permisos por rol
        $permisosPorRol = [
            'Administrador General' => $permissions, // todos los permisos

            'Administrador Sucursal' => [

                // Productos
                'ver productos',
                'crear productos',
                'editar productos',
                'eliminar productos',

                //innventario
                'ver inventarios',
                'editar inventarios',
                'movimientos inventario',

                // Ventas y
                'ver ventas',
                'crear ventas',
                'editar ventas',
                'anular ventas',

                // Planes de reserva
                'ver planes',
                'crear planes',
                'editar planes',
                'eliminar planes',

                // Pagos
                'ver pagos',
                'registrar pagos',
                'editar pagos',
                'eliminar pagos',

                // Clientes
                'ver clientes',
                'crear clientes',
                'editar clientes',
                'eliminar clientes',

                // Reportes
                'ver reportes',

                //transacciones
                'ver transacciones',
            ],

            'Supervisor' => [
                // Productos
                'ver productos',

                //innventario
                'ver inventarios',

                // Ventas y
                'ver ventas',

                // Planes de reserva
                'ver planes',

                // Pagos
                'ver pagos',

                // Clientes
                'ver clientes',

                // Reportes
                'ver reportes',

                //transacciones
                'ver transacciones',
            ],

            'Asesor Interno' => [
                // Productos
                'ver productos',
                'crear productos',

                //innventario
                'ver inventarios',
                'editar inventarios',
                'movimientos inventario',

                // Ventas y
                'ver ventas',
                'crear ventas',

                // Planes de reserva
                'ver planes',
                'crear planes',
                'editar planes',

                // Pagos
                'ver pagos',
                'registrar pagos',
                'editar pagos',

                // Clientes
                'ver clientes',
                'crear clientes',
                'editar clientes',

                // Reportes
                'ver reportes',

                //transacciones
                'ver transacciones',
            ],

            'Asesor Externo' => [
                // Productos
                'ver productos',
                'crear productos',

                //innventario
                'ver inventarios',
                'editar inventarios',
                'movimientos inventario',

                // Ventas y
                'ver ventas',
                'crear ventas',

                // Planes de reserva
                'ver planes',
                'crear planes',
                'editar planes',

                // Pagos
                'ver pagos',
                'registrar pagos',
                'editar pagos',

                // Clientes
                'ver clientes',
                'crear clientes',
                'editar clientes',

                // Reportes
                'ver reportes',

                //transacciones
                'ver transacciones',
            ],

            'Auditor' => [
                // Productos
                'ver productos',

                //innventario
                'ver inventarios',

                // Ventas y
                'ver ventas',

                // Planes de reserva
                'ver planes',

                // Pagos
                'ver pagos',

                // Clientes
                'ver clientes',

                // Reportes
                'ver reportes',

                //transacciones
                'ver transacciones',
            ],

            'Cliente' => [
                'ver productos',
                'ver planes',
                'ver pagos',
                'ver transacciones',
                'ver reportes',
            ],
        ];


        // 5. Crear roles y asignar permisos
        foreach ($roles as $roleData) {
            $role = Role::firstOrCreate(
                [
                    'name' => $roleData['name'],
                    'guard_name' => 'api',
                    'company_id' => $company->id
                ],
                [
                    'description' => $roleData['description']
                ]
            );

            if (isset($permisosPorRol[$roleData['name']])) {
                $permisos = Permission::where('company_id', $company->id)
                    ->whereIn('name', $permisosPorRol[$roleData['name']])
                    ->get();

                $role->syncPermissions($permisos);
            }
        }
    }
}
