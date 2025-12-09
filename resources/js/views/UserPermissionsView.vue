<template>
    <div class="m-0 p-0 w-full">
        <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100 dark:bg-gray-800 dark:border-gray-700">


        <HeaderButtonGenInformComplet :title="`Permisos del Usuario Actual `" :isDopDownVisible=true>
            <template #icon>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8.25v-2.5m0 0c0-.69-.56-1.25-1.25-1.25H6.25A1.25 1.25 0 005 4.75v14.5c0 .69.56 1.25 1.25 1.25h4.5c.69 0 1.25-.56 1.25-1.25v-2.5m0-12.5h3.5c.69 0 1.25.56 1.25 1.25v3.5m-4.75 7.25h6.5c.69 0 1.25-.56 1.25-1.25V9.75L15.5 6H12m0 8.25H9.75m2.25 3H9.75" />
                </svg>

            </template>
        </HeaderButtonGenInformComplet>

            <div class="mb-8 p-4 bg-indigo-50 rounded-xl dark:bg-indigo-900/50">
                <span class="text-lg font-bold text-indigo-700 dark:text-indigo-300">
                    Permisos Activos: {{ allPermissions.length }}
                </span>
            </div>


                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
                    <div class="col-span-1 bg-gray-50 p-6 rounded-xl border dark:bg-gray-700 dark:border-gray-600">

                <div class="col-span-1">
                    <h3 class="text-xl font-bold mb-4 text-indigo-600 dark:text-indigo-400 border-b pb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        Lista General ({{ allPermissions.length }} items)
                    </h3>

                    <ul class="space-y-1 h-96 overflow-y-auto pr-3 custom-scrollbar">
                        <li v-for="(permission, index) in allPermissions" :key="permission.id"
                            class="flex items-center p-2 rounded-lg bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 transition duration-150">

                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>

                            <span class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                {{ index + 1 }}. {{ permission.name }}
                            </span>
                        </li>
                    </ul>
                </div>
                </div>

                <PermissionGroupCard
                    title="Administración & Roles"
                    :permissions="['ver usuarios', 'crear usuarios', 'editar usuarios', 'eliminar usuarios', 'ver roles', 'crear roles', 'editar roles', 'eliminar roles']"
                    :allPermissions="allPermissions"
                    icon="👥"
                />

                <PermissionGroupCard
                    title="Inventario, Ventas & Clientes"
                    :permissions="['ver productos', 'crear productos', 'editar productos', 'eliminar productos', 'ver inventarios', 'crear inventarios', 'ver ventas', 'crear ventas', 'ver clientes', 'crear clientes']"
                    :allPermissions="allPermissions"
                    icon="💰"
                />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">

                <PermissionGroupCard
                    title="Finanzas, Proveedores & Documentos"
                    :permissions="['ver cxp', 'ver cxc', 'ver proveedores', 'crear proveedor', 'crear documentos', 'ver documentos', 'ver pagos', 'registrar pagos']"
                    :allPermissions="allPermissions"
                    icon="⚙️"
                />

                <PermissionGroupCard
                    title="Configuración & Reportes"
                    :permissions="['ver reportes', 'configurar empresa', 'configurar sucursales', 'crear sucursal', 'ver sucursales', 'datos generales']"
                    :allPermissions="allPermissions"
                    icon="📊"
                />

                <div class="col-span-1 bg-gray-50 p-6 rounded-xl border dark:bg-gray-700 dark:border-gray-600">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-200">Información Adicional</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        Esta es la fuente única de verdad para el control de acceso en la aplicación. Si un permiso falta, el backend no lo está adjuntando correctamente.
                    </p>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useAuthStore } from '@/stores/useAuthStore';
// 🛑 Necesitarás crear este componente nuevo para manejar las tarjetas
import PermissionGroupCard from '../components/PermissionGroupCard.vue';
import HeaderButtonGenInformComplet from '../components/HeaderButtonGenInformComplet.vue'

const authStore = useAuthStore();

// 1. Acceder al objeto user
const user = computed(() => authStore.user);

// 2. Extraer el array de permisos unificados.
const allPermissions = computed(() => {
    // Retorna el array 'permissions' que ya ha sido sobrescrito en Laravel con la lista completa.
    // Usamos el ? y || [] para evitar errores si la data aún no carga.
    return user.value?.permissions || [];
});

</script>

<style scoped>
/* Estilo para la barra de desplazamiento (para navegadores basados en Webkit) */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: #cbd5e1; /* gray-300 */
    border-radius: 3px;
}
</style>
