<template>

    <!--<div class="w-64 bg-white border-r border-gray-200 h-full flex flex-col">-->
    <div class="fixed md:relative flex flex-col inset-y-0 left-0 z-30 bg-white shadow-xl
           transform transition-all duration-300 ease-in-out overflow-hidden" :class="[
            // Ancho dinámico → lo que realmente evita el espacio ocupado
            isOpen ? 'w-64' : 'w-0',

            // Móvil: desliza el sidebar
            isOpen ? 'translate-x-0' : '-translate-x-full',
            'ml-0',

            // Escritorio: NO desliza, solo cambia el ancho
            'md:translate-x-0', 'md:ml-1',
        ]">




        <div class="bg-white w-64 border-r shadow-sm">
            <div class="border-t mt-auto">
                <div class="p-4 hover:bg-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2 w-full justify-center">
                            <span class="text-sm  text-center  coompany-title-color ">
                                <b>{{ authStore.user.company.name.toUpperCase() }}</b>
                            </span>
                        </div>
                        <button @click="emit('toggle-sidebar')"
                            class="text-gray-500 hover:text-gray-600 md:hidden p-1 rounded-full hover:bg-gray-100 transition">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="bg-white pt-3 rounded-xl shadow-lg mb-4 flex flex-col items-center">

                        <div class="h-32 w-full max-w-xs flex items-center justify-center pb-1 mb-4 ">
                            <img :src="authStore.user.company.logo_path ? authStore.user.company.logo_path : '/avatars/default-avatar.png'"
                                alt="Logo de la empresa" class="h-full max-h-32 w-auto object-contain rounded-lg
           opacity-80 border-2 border-transparent
           transition duration-300 ease-in-out
           hover:opacity-100 hover:border-indigo-500" />
                        </div>

                        <div class="flex flex-col items-center w-full">
                            <span class="text-sm font-bold text-gray-800 text-center mb-1">
                                {{ $capitalizeWords(authStore.user.branch?.name) }}
                            </span>

                            <p class="text-sm text-gray-500 text-center font-medium">
                                {{ $capitalizeWords(authStore.user.branch?.city) }} ({{
                                    $capitalizeWords(authStore.user.branch?.department) }})
                            </p>
                        </div>

                    </div>
                    <hr class="mt-4 border-gray-200">
                </div>
            </div>
            <div class=" mb-4 h-full overflow-y-auto max-h-screen pb-0" v-if="authStore.user.branch?.active === 1">
                <div class="px-4 mb-4">
                    <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">PANEL DE NAVEGACIÓN<br><br>

                    </h2>
                    <nav class="mt-2 space-y-1">


                        <RouterLink to="/"
                            class="flex items-center px-4 py-2 text-sm font-medium text-indigo-600 bg-gray-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="h-5 w-5 mr-3 icon-tabler-glasses">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M6 15a2 2 0 1 0 0 4a2 2 0 0 0 0 -4z" />
                                <path d="M18 15a2 2 0 1 0 0 4a2 2 0 0 0 0 -4z" />
                                <path d="M15 15h3l3.5 -4l-3.5 -4h-1c-.422 0 -1.02 .234 -1.412 .574" />
                                <path d="M9 15h-3l-3.5 -4l3.5 -4h1c.422 0 1.02 .234 1.412 .574" />
                            </svg>
                            <b>Dashboard</b>
                        </RouterLink>

                        <RouterLink to="/SaleRegistration"
                            class="flex items-center px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg">
                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <b>Vender Productos</b>
                        </RouterLink>


                        <RouterLink to="/AccountsReceivable"
                            class="flex items-center px-4 py-2 text-sm font-medium text-dark-600 bg-orange-50 rounded-lg">
                            <svg class="w-6 h-6 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" role="img"
                                aria-label="Caja">
                                <title>Caja / Orden</title>
                                <path d="M21 16V8l-9-5-9 5v8l9 5 9-5z" />
                                <path d="M3.27 6.96L12 11.18l8.73-4.22" stroke-opacity="0.6" />
                                <path d="M12 11v10" />
                            </svg>
                            <b>&nbsp;&nbsp;Compras IA</b>
                        </RouterLink>
                        <div class="relative">
                            <button @click="toggleMenu('ventas')"
                                class="w-full flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg cursor-pointer">

                                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Ventas
                                <svg class="ml-auto h-4 w-4 transform transition-transform"
                                    :class="{ 'rotate-180': menuStates.ventas }" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div v-show="menuStates.ventas" class="mt-1 pl-11 space-y-1 submenu">
                                <RouterLink to="/Sales"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Lista
                                    Ventas
                                </RouterLink>

                            </div>
                        </div>
                        <div class="relative">
                            <button @click="toggleMenu('inventario')"
                                class="w-full flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg cursor-pointer">

                                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10m-8-4l8 4m0-10l-8 4m8-4l8 4" />
                                </svg>
                                Inventario
                                <svg class="ml-auto h-4 w-4 transform transition-transform"
                                    :class="{ 'rotate-180': menuStates.inventario }" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div v-show="menuStates.inventario" class="mt-1 pl-11 space-y-1 submenu">
                                <RouterLink to="/InventoriesBranch"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Listar
                                    Productos
                                </RouterLink>

                                <RouterLink to="/InventoryRegistration"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Registrar
                                    Producto
                                </RouterLink>
                            </div>
                        </div>


                        <div class="relative">
                            <button @click="toggleMenu('clientes')"
                                class="w-full flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg cursor-pointer">

                                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                Clientes
                                <svg class="ml-auto h-4 w-4 transform transition-transform"
                                    :class="{ 'rotate-180': menuStates.clientes }" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div v-show="menuStates.clientes" class="mt-1 pl-11 space-y-1 submenu">
                                <RouterLink to="/clients"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Lista
                                    Clientes
                                </RouterLink>
                                <RouterLink to="/ClientsRegistration"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Registrar
                                    Cliente
                                </RouterLink>

                            </div>
                        </div>

                        <div class="relative">
                            <button @click="toggleMenu('usuarios')"
                                class="w-full flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg cursor-pointer">

                                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Colaboradores
                                <svg class="ml-auto h-4 w-4 transform transition-transform"
                                    :class="{ 'rotate-180': menuStates.usuarios }" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div v-show="menuStates.usuarios" class="mt-1 pl-11 space-y-1 submenu">
                                <RouterLink to="/users"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Listar
                                    Colaboradores
                                </RouterLink>

                                <RouterLink to="/UserRegistration"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Registrar
                                    Colaborador</RouterLink>
                                <RouterLink to="/UserPermissions"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Permisos
                                </RouterLink>
                            </div>
                        </div>

                        <div class="relative">
                            <button @click="toggleMenu('sucursales')"
                                class="w-full flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg cursor-pointer">

                                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6m-6 0v-4a1 1 0 011-1h2a1 1 0 011 1v4" />
                                </svg>
                                Sucursales
                                <svg class="ml-auto h-4 w-4 transform transition-transform"
                                    :class="{ 'rotate-180': menuStates.sucursales }" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div v-show="menuStates.sucursales" class="mt-1 pl-11 space-y-1 submenu">
                                <RouterLink to="/sucursals"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Listar
                                    Sucursales
                                </RouterLink>

                                <RouterLink to="/BranchRegistration"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Registrar
                                    Sucursales
                                </RouterLink>
                            </div>
                        </div>


                        <div class="relative">
                            <button @click="toggleMenu('proveedores')"
                                class="w-full flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg cursor-pointer">

                                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                        d="M5 9m14 0l-7 7m0 0l-7-7M5 9a2 2 0 110-4 2 2 0 010 4zm14 0a2 2 0 110-4 2 2 0 010 4zm-9 9a2 2 0 11-4 0 2 2 0 014 0zM12 4h4l3 4V8m-7 0v2m0 0h-2M12 4v2m0 0h2m-6 0h2M12 4v2m0 0h2m-6 0h2" />
                                </svg>
                                Proveedores
                                <svg class="ml-auto h-4 w-4 transform transition-transform"
                                    :class="{ 'rotate-180': menuStates.proveedores }" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div v-show="menuStates.proveedores" class="mt-1 pl-11 space-y-1 submenu">
                                <RouterLink to="/Suppliers"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Listar
                                    Proveedores
                                </RouterLink>

                                <RouterLink to="/SupplierRegistration"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Registrar
                                    Proveedor
                                </RouterLink>
                            </div>
                        </div>

                        <RouterLink to="/AccountsReceivable"
                            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">
                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 0a8 8 0 00-4 4h14a8 8 0 00-4-4H7zM3 4h18a2 2 0 012 2v2a2 2 0 01-2 2H3a2 2 0 01-2-2V6a2 2 0 012-2z" />
                            </svg>
                            Cuentas X Cobrar
                        </RouterLink>

                    </nav>
                </div>

                <div class="px-4 mb-4  pb-4">
                    <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Administración</h2>
                    <nav class="mt-2 space-y-1">
                        <a href="#"
                            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">
                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6m0 0h18M10 19l3-9 3 9m-10 0l3-9 3 9m-10 0V5a2 2 0 012-2h4a2 2 0 012 2v14" />
                            </svg>
                            Gráficas Anaálisis
                        </a>
                        <a href="#"
                            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">
                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                    d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M8 5h8a2 2 0 012 2v8a2 2 0 01-2 2H8a2 2 0 01-2-2V7a2 2 0 012-2zM9 9h6v6H9V9z" />
                            </svg>
                            <b>Analítica IA</b>
                        </a>
                        <a href="#"
                            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">
                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Ajustes
                        </a>

                        <a href="#"
                            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">
                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            Preferencias
                        </a>
                    </nav>
                </div>
                <br>

                <div class="px-4 mb-4">
                    <h2 class="text-xs font-semibold text-green-500 uppercase tracking-wider">Visual Hub 360
                        <span></span>
                    </h2>
                    <nav class="mt-2 space-y-1">
                        <a href="#"
                            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">
                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                    d="M21 16v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6m18 0v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2" />
                            </svg>
                            Soporte y Ayuda
                        </a>

                    </nav>
                </div>
                <div class="px-4 mb-4">
                    <br><br><br><br><br><br><br><br><br><br><br><br><br>
                </div>
            </div>
            <data v-else>

                <div class="p-4">

                    <h2 class="text-sm font-semibold text-red-500"><svg class="h-12 w-12 mr-3 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 6l12 12M18 6L6 18" />
                        </svg>Sucursal Inactiva</h2>
                    <p class="text-xs text-gray-600 mt-2">Por favor, contacte al administrador de su empresa para
                        reactivar
                        esta sucursal y poder acceder al sistema.</p>
                </div>
                <div class="px-4 mb-4">
                    <h2 class="text-xs font-semibold text-green-500 uppercase tracking-wider">Visual Hub 360
                        <span></span>
                    </h2>
                    <nav class="mt-2 space-y-1">
                        <a href="#"
                            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">
                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                    d="M21 16v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6m18 0v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2" />
                            </svg>
                            Soporte y Ayuda
                        </a>

                    </nav>
                </div>
            </data>
        </div>
        <div class="flex-1 bg-gray-50 flex"></div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/useAuthStore'
const authStore = useAuthStore()

// La función que sí es visible en el template

const emit = defineEmits(['toggle-sidebar']);


console.log('que emite emit en sidebar : ' + emit)// Aquí sí usamos la función emit

// CLAVE 2: ELIMINAR isSidebarOpen, toggleSidebar, y defineExpose.

// Lógica de menú
const menuStates = ref({
    clientes: false,
    ventas: false,
    usuarios: false,
    sucursales: false,
    inventario: false,
    proveedores: false,
});





// Define el estado inicial del sidebar
const isSidebarOpen = ref(true);

// Función para alternar el estado
const toggleSidebar = () => {

    console.log("Toggling sidebar :" + isSidebarOpen.value);
    isSidebarOpen.value = !isSidebarOpen.value;
};

defineExpose({
    toggleSidebar
});




// Definir la función que alterna el estado del menú ESPECÍFICO.
const toggleMenu = (menuName) => {
    menuStates.value[menuName] = !menuStates.value[menuName];

    // Si quieres comportamiento de acordeón:
    for (const key in menuStates.value) {
        if (key !== menuName) {
            menuStates.value[key] = false;
        }
    }
};

// Se mantienen las props si las estás usando en el componente padre
defineProps({ isOpen: Boolean });
</script>
