<template>
    <div class="flex-1 p-0 flex flex-col">
        <!-- Navbar -->
        <header class="bg-white shadow p-2 flex justify-between items-center">
            <!-- CLAVE 1: BOTÓN DE HAMBURGUESA (visible solo en móvil) -->


            <h1 class="text-lg font-semibold">
                <button @click="emit('toggle-sidebar')" aria-label="Toggle sidebar"
                    class="p-2 rounded-md hover:bg-gray-100 md:hover:bg-transparent">
                    <!-- SVG con clase Tailwind y fallback por style binding -->
                    <svg class="h-6 w-6 text-gray-700 transition-transform duration-300"
                        :class="{ 'transform rotate-90': props.isOpen }"
                        :style="{ transform: props.isOpen ? 'rotate(0deg)' : 'rotate(90deg)' }" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2">

                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 18h16" />
                    </svg>

                </button>
            </h1>
            <!--<button @click="logout" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">
                Cerrar sesión
            </button>-->
            <div class="relative gradient-button inline-block text-left">
                <button @click="isDropdownOpen = !isDropdownOpen" type="button"
                    class="gradient-button w-full py-1 px-6 rounded-xl font-semibold shadow-lg shadow-purple-500/30 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-indigo-300 active:bg-indigo-800 text-base">

                    <span class="flex items-center justify-center">
                        ¡Bienvenido, {{ authStore.user?.name || 'Usuario' }}!
                        <svg class="w-2.5 h-2.5 ms-3 transition-transform duration-200"
                            :class="{ 'rotate-180': isDropdownOpen }" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </span>
                </button>

                <div v-if="isDropdownOpen"
                    class="absolute right-0 mt-2 z-10 bg-white divide-y divide-gray-100 rounded-lg shadow-xl w-44 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                        <li>
                            <a href="#"
                                class="inline-flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">

                                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>

                                Sus Datos

                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="inline-flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">

                                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>

                                Ganancias

                            </a>
                        </li>
                        <li>

                            <a href="#"
                                class="inline-flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">

                                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>

                                Ajustes

                            </a>
                        </li>

                        <li>

                            <a @click="logout"
                                class="inline-flex items-center w-full p-2 text-red-600 hover:bg-red-100 rounded cursor-pointer">

                                <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                                </svg>

                                Cerrar Sesión
                            </a>

                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <!-- Page Content -->
        <main class="flex-1 p-1 overflow-y-auto">
            <RouterView></RouterView>

        </main>


    </div>

</template>


<script setup>
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/useAuthStore'
import { ref } from 'vue'
//import Footer from '../components/Footer.vue' // <-- ¡Añadir el Footer!
const emit = defineEmits(['toggle-sidebar'])

// Recibe la prop que viene del layout: :is-open="isSidebarOpen"
const props = defineProps({
    isOpen: { type: Boolean, default: false } // usa aquí el mismo nombre que en el parent
})
const isDropdownOpen = ref(false);

const router = useRouter()
const authStore = useAuthStore() // INICIALIZAR LA STORE

const logout = () => {
    // 1. Ejecutar la acción de logout de la store
    // Esta acción pondrá this.token, this.user, y this.branch en null.
    // También se encarga de limpiar el localStorage.
    authStore.logout()

    // 2. Navegar al login
    // Usar el nombre de la ruta es la mejor práctica
    router.push({ name: 'Login' })

    // Si prefieres el path: router.push('/login')
}
</script>
