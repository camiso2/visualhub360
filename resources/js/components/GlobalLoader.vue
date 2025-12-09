<template>
    <Transition name="fade-scale">
        <div v-if="authStore.loading"
             class="fixed inset-0 z-[9999] flex items-center justify-center
                    bg-gray-900/70 backdrop-blur-md">

            <div class="flex flex-col items-center p-10 rounded-2xl shadow-2xl
                        bg-white/95 border border-indigo-100/50
                        transform scale-100 transition-transform duration-300">

                <div class="relative h-16 w-16 mb-6">
                    <div class="absolute h-full w-full border-4 border-gray-200 border-t-indigo-600 border-solid rounded-full animate-spin"></div>

                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2
                                h-4 w-4 bg-indigo-500 rounded-full shadow-inner"></div>
                </div>

                <p class="text-xl font-extrabold text-indigo-700 tracking-wider">
                    PROCESANDO SOLICITUD...
                </p>
                <p class="text-sm text-gray-500 mt-2">
                    Validando Información. Por favor, espere...
                </p>
            </div>
        </div>
    </Transition>
</template>

<script setup>
import { useAuthStore } from '@/stores/useAuthStore';
// Lee la variable que ya tienes definida
const authStore = useAuthStore();
</script>

<style scoped>
/* Transición simple */
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>
