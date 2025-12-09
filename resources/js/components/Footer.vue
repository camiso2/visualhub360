<template>
    <footer class="bg-gray-50 border-t border-gray-200 py-4 px-6 w-full shadow-inner">
        <div class="max-w-7xl mx-auto flex flex-col justify-center items-center text-xs text-gray-500 space-y-2">

            <div class="text-center flex items-center space-x-2">
                <span>
                    &copy; {{ currentYear }} <span class="font-semibold text-gray-700">
                    {{ $capitalizeWords('VisualHub360') }}</span>. Todos los derechos reservados, <b>CrearSoft, </b> Jaiver A. Ocampo
                </span>

                <span class="mx-2 text-gray-400"> | </span>

                <span v-if="authStore.user && authStore.user.branch">
                    Sucursal Activa:
                    <span class="font-bold text-indigo-600">
                        {{ $capitalizeWords(authStore.user.branch.name) }}
                    </span>
                    <span class="mx-2 text-gray-400"> | </span>
                    {{ $capitalizeWords(authStore.user.branch.city) }} ({{ $capitalizeWords(authStore.user.branch.department) }})
                    <span class="mx-2 text-gray-400"> | Contacto : </span>
                    {{ $capitalizeWords(authStore.user.branch.phone) }}
                </span>
                <span v-else class="text-red-500 font-semibold">
                    SESIÓN CERRADA. Inicie sesión para activar la sucursal.
                </span>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { watch } from 'vue';
import { useRouter } from 'vue-router';
// Asume que la ruta a tu store es correcta
import { useAuthStore } from '@/stores/useAuthStore.js';

const router = useRouter();
const authStore = useAuthStore();

// --- FUNCIÓN QUE GARANTIZA EL CIERRE Y LA REDIRECCIÓN ---
const logoutAndRedirect = () => {
    // Evita que la función se ejecute en bucle si ya estamos en la página de Login
    if (router.currentRoute.value.name === 'Login') {
        return;
    }

    // 1. Limpia el estado de Pinia/Store
    authStore.logout();

    // 2. Redirecciona al Login
    console.warn("Estado de sesión incompleto/inválido detectado. Redirigiendo a Login.");
    router.push({ name: 'Login' });
};


// --- EL OBSERVADOR (WATCHER) CLAVE ---
// Este código se ejecuta inmediatamente al cargar y cada vez que cambia el branch.
watch(() => authStore.user?.branch, (newBranch) => {

    // Condición de Inconsistencia:
    // Si authStore.user EXISTE (la persona está "logueada")
    // PERO authStore.user.branch NO EXISTE (el dato esencial para la aplicación falla)
    // -> Ejecutar cierre de sesión forzado.
    if (authStore.user && !newBranch) {
        logoutAndRedirect();
    }

}, { immediate: true }); // { immediate: true } asegura que se compruebe al cargar.

// Definición de currentYear y otras variables si las usas en el template
const currentYear = new Date().getFullYear();

// Define la función `logout` para cualquier botón de la interfaz que lo requiera.
// Aunque la función del watch es forzar el logout por inconsistencia,
// puedes reutilizar esta misma función para un botón de "Cerrar Sesión" si es necesario.
const logout = () => {
    logoutAndRedirect();
};

// ... (Otras setup variables y funciones aquí) ...
</script>


