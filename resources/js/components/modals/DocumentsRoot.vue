<template>
    <transition name="modal-fade">
        <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" @click="closeModal"></div>

            <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full transform transition-all
               sm:max-w-xl md:max-w-2xl lg:max-w-3xl dark:bg-gray-800" role="dialog" aria-modal="true"
                aria-labelledby="modal-title">
                <div v-if="showCloseButton || title"
                    class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 v-if="title" id="modal-title" class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ title }}
                    </h3>
                    <button v-if="showCloseButton" @click="closeModal"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span class="sr-only">Cerrar modal</span>
                    </button>
                </div>

                <div class="p-4 overflow-y-auto max-h-[80vh]">
                    <div v-if="props.clientId">
                        <!---<p class="text-sm font-medium text-indigo-600 dark:text-indigo-400 mb-4">
                            Procesando documento para el Cliente ID:
                            <span class="font-bold">{{ props.clientId }}</span>
                        </p>
                        <hr class="mb-4" />-->
                    </div>
                    <slot></slot>
                </div>

                <div v-if="$slots.footer"
                    class="flex justify-end p-4 border-t border-gray-200 dark:border-gray-700 space-x-2">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </transition>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        default: ''
    },
    // 💡 NUEVA PROP para recibir el ID del cliente
    clientId: {
        type: [Number, String], // El tipo depende de cómo almacenes el ID
        default: null
    },
    showCloseButton: {
        type: Boolean,
        default: true
    },
    closeOnOverlayClick: {
        type: Boolean,
        default: true
    },
    closeOnEscape: {
        type: Boolean,
        default: true
    }
});

const emit = defineEmits(['update:modelValue', 'close', 'open']);

const isOpen = ref(props.modelValue);

// Sincronizar el estado interno con la prop `modelValue`
watch(() => props.modelValue, (newValue) => {
    isOpen.value = newValue;
    if (newValue) {
        emit('open');
        document.body.style.overflow = 'hidden'; // Evita el scroll del body
    } else {
        emit('close');
        document.body.style.overflow = ''; // Restaura el scroll del body
    }
});

// Cerrar el modal
const closeModal = () => {
    if (props.closeOnOverlayClick) { // Solo cierra si closeOnOverlayClick es true
        isOpen.value = false;
        emit('update:modelValue', false);
    }
};

// Manejar la tecla Escape
const handleEscapeKey = (event) => {
    if (props.closeOnEscape && event.key === 'Escape' && isOpen.value) {
        closeModal();
    }
};

onMounted(() => {
    document.addEventListener('keydown', handleEscapeKey);
    if (props.modelValue) {
        document.body.style.overflow = 'hidden';
    }
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleEscapeKey);
    document.body.style.overflow = ''; // Asegura restaurar el scroll
});
</script>

<style scoped>
/* Transiciones básicas de Vue */
.modal-fade-enter-active,
.modal-fade-leave-active {
    transition: opacity 0.3s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
    opacity: 0;
}

/* Opcional: Transición para el contenido del modal */
.modal-fade-enter-active .relative,
.modal-fade-leave-active .relative {
    transition: all 0.3s ease-in-out;
}

.modal-fade-enter-from .relative,
.modal-fade-leave-to .relative {
    transform: scale(0.95);
    opacity: 0.9;
}
</style>
