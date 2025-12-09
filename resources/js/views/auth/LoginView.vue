<template>
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-blue-100 p-6">
        <div
            class="relative bg-white/70 backdrop-blur-lg p-8 sm:p-10 rounded-2xl shadow-xl w-full max-w-md border border-indigo-100 hover:shadow-2xl transition-all duration-300">

            <div class="absolute -top-6 -left-6 w-20 h-20 bg-indigo-500 rounded-full opacity-10 blur-2xl"></div>
            <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-blue-400 rounded-full opacity-10 blur-3xl"></div>

            <div class="text-center mb-8">
                <div class="flex justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-indigo-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3v-1m18-4V7a3 3 0 00-3-3H6a3 3 0 00-3 3v1" />
                    </svg>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">
                    Bienvenido de nuevo
                </h2>
                <p class="mt-2 text-sm text-gray-500">
                    Ingresa tus credenciales para continuar
                </p>
            </div>

            <form @submit.prevent="handleSubmit" class="space-y-5">
                <div v-if="loginError" class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg text-sm"
                    role="alert">
                    <p class="font-semibold">Error de autenticación:</p>
                    <p>{{ loginError }}</p>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                    <input id="email" type="email" v-model="credentials.email" required autocomplete="email"
                        placeholder="ejemplo@empresa.com" :disabled="loading"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                    <input id="password" type="password" v-model="credentials.password" required
                        autocomplete="current-password" placeholder="••••••••" :disabled="loading"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
                </div>

                <div>
                    <label for="branch_code" class="block text-sm font-medium text-gray-700 mb-1">Código de
                        Sucursal</label>
                    <input id="branch_code" type="text" v-model="credentials.branch_code" placeholder="WMR38G"
                        :disabled="loading"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
                </div>

                <button type="submit" :disabled="loading"
                    class="w-full flex justify-center items-center py-3 px-4 rounded-lg font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 disabled:opacity-70 disabled:cursor-not-allowed transform hover:scale-[1.02] transition-all duration-150">

                    <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2.01 5.938A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>

                    <span>{{ loading ? 'Cargando...' : 'Iniciar sesión' }}</span>
                </button>
            </form>

            <div class="mt-6 text-center space-y-3">
                <router-link :to="{ path: '/registerCompany' }"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition block border-b border-dashed border-indigo-200 pb-1">
                    🚀 ¿No tienes una empresa? ¡Regístrala aquí!
                </router-link>

                <a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-600 transition block">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { useAuthStore } from '@/stores/useAuthStore'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

const credentials = reactive({
    email: '',
    password: '',
    branch_code: ''
})

// Definición del estado de carga del componente
const loading = ref(false);
const loginError = ref(null);

const handleSubmit = async () => {
    loading.value = true; // Iniciar la carga
    loginError.value = null;

    try {
        // Ejecutar el login y capturar los datos (incluyendo needs_branch_setup)
        const responseData = await authStore.login(credentials);

        // Lógica de Redirección Condicional
        if (responseData && responseData.needs_branch_setup) {
            // Empresa nueva -> Redirigir a configuración de sucursal
            router.push({ name: 'BranchRegistration' });

        } else {
            // Login exitoso -> Redirigir al Dashboard
            router.push({ name: 'Dashboard' });
        }

    } catch (error) {
        // Manejo de errores
        loginError.value =
            authStore.error ||
            error.message ||
            'Ocurrió un error inesperado al intentar iniciar sesión.';

    } finally {
        // Detener la carga, rompiendo el bloqueo del spinner
        loading.value = false;
    }
}
</script>
