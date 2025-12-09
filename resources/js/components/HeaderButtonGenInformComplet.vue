<template>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between
               gap-3 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
        <!-- Título -->
        <div class="flex items-center space-x-2 md:space-x-3">
            <span class="p-2 rounded-xl bg-indigo-100 dark:bg-indigo-900/40
                       text-indigo-700 dark:text-indigo-300 shadow-sm">
                <slot name="icon"></slot>

            </span>
            <p class="text-lg md:text-lg font-semibold text-gray-500 ">
                {{ title }}
            </p>
        </div>

        <div v-if="isDopDownVisible" class="relative self-end md:self-auto" ref="dropdownRef">

            <!-- Botón principal -->
            <button @click="toggleDropdown" class="px-3 py-2 md:px-4 md:py-2 rounded-lg bg-transparent
                       border border-indigo-500/40 text-indigo-600 dark:text-indigo-300
                       hover:bg-indigo-600/10 hover:border-indigo-600
                       transition-all duration-200 active:scale-95
                       flex items-center space-x-2 text-sm md:text-base">

                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 2a2 2 0 002-2h2a2 2 0 002-2m-2-2h0V9h0" />
                </svg>

                <span class="font-medium">Generar Informe</span>

                <svg :class="[
                    'w-3 h-3 md:w-4 md:h-4 text-indigo-500 transform transition-transform duration-300',
                    isOpen ? 'rotate-180' : 'rotate-0'
                ]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown -->
            <div v-if="openDropdown" class="absolute right-0 mt-2 w-40 md:w-44 bg-white dark:bg-gray-800 shadow-lg rounded-lg
                       overflow-hidden border border-indigo-500/20 z-50">

                <button @click="generatePDF" class="w-full px-4 py-2 text-left text-sm hover:bg-indigo-600/10
                           text-gray-700 dark:text-gray-300">
                    📄 Exportar PDF
                </button>

                <button @click="generateExcel" class="w-full px-4 py-2 text-left text-sm hover:bg-indigo-600/10
                           text-gray-700 dark:text-gray-300">
                    📊 Exportar Excel
                </button>
            </div>
        </div>

    </div>
</template>


<script setup>

import { ref, onMounted, onBeforeUnmount } from 'vue';
import api from '@/plugins/axios';

defineProps({
    title: {
        type: String,
        required: true
    },
    isDopDownVisible: {
        type: Boolean,
        required: true,
    }
})

const openDropdown = ref(false)
const dropdownRef = ref(null)
const isOpen = ref(false);


const toggleDropdown = () => {
    openDropdown.value = !openDropdown.value
    isOpen.value = !isOpen.value;
}

// Cerrar cuando se hace click afuera (funciona en Vue)
const handleClickOutside = (e) => {
    if (dropdownRef.value && !dropdownRef.value.contains(e.target)) {
        openDropdown.value = false
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside)
})

// Acciones
const generatePDF = () => {
    openDropdown.value = false
    console.log("Generando PDF…")
}

const generateExcel = () => {
    openDropdown.value = false
    console.log("Generando Excel…")
}



</script>
