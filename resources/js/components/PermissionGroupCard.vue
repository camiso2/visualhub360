<template>
    <div class="col-span-1 bg-white p-6 rounded-xl shadow-md border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
        <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white flex items-center">
            <span class="mr-2">{{ icon }}</span>
            {{ title }}
        </h3>
        <div class="space-y-3">
            <div v-for="p in permissions" :key="p" class="flex items-center justify-between p-2 rounded-lg"
                 :class="hasPermission(p) ? 'bg-green-50 dark:bg-green-900/30' : 'bg-red-50 dark:bg-red-900/30'">

                <span class="text-sm font-medium"
                      :class="hasPermission(p) ? 'text-green-800 dark:text-green-300' : 'text-red-800 dark:text-red-300'">
                    {{ p }}
                </span>

                <svg v-if="hasPermission(p)" class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <svg v-else class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    // Lista de permisos que esta tarjeta debe verificar (ej: ['ver usuarios'])
    permissions: {
        type: Array,
        required: true,
    },
    // El array COMPLETO de permisos del usuario (el que viene del store)
    allPermissions: {
        type: Array,
        required: true,
    },
    icon: {
        type: String,
        default: '📄',
    },
});

// Función para verificar si un permiso está en la lista completa
const hasPermission = (permissionName) => {
    // Busca en el array completo (props.allPermissions)
    return props.allPermissions.some(p => p.name === permissionName);
};
</script>
