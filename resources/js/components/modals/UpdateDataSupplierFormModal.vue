<template>
    <DocumentsRoot :modelValue="props.modelValue" @update:modelValue="value => emit('update:modelValue', value)"
        title=" " :supplier-id="props.supplierId">

        <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700 ">

            <HeaderButtonGenInformComplet :title="`Actualizar Datos del Provedor`"
                :isDopDownVisible="false">
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8.25v-2.5m0 0c0-.69-.56-1.25-1.25-1.25H6.25A1.25 1.25 0 005 4.75v14.5c0 .69.56 1.25 1.25 1.25h4.5c.69 0 1.25-.56 1.25-1.25v-2.5m0-12.5h3.5c.69 0 1.25.56 1.25 1.25v3.5m-4.75 7.25h6.5c.69 0 1.25-.56 1.25-1.25V9.75L15.5 6H12m0 8.25H9.75m2.25 3H9.75" />
                    </svg>
                </template>
            </HeaderButtonGenInformComplet>

            <div v-if="errorMessage"
                class="w-full bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded text-sm">
                <p class="font-semibold">Error:</p>
                <p>{{ errorMessage }}</p>
            </div>
            <div v-if="successMessage" class="w-full mt-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ successMessage }}
            </div>

            <div class="w-full overflow-x-auto border rounded-lg bg-indigo-50 rounded-xl p-3 border mb-5">
                <input type="hidden" :value="form.id" readonly />


                <div class="flex flex-col w-full md:w-64">
                    <label class="text-sm font-medium text-gray-700"> Documento Proveedor</label>
                    <span
                        class="bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300 px-3 py-2 text-xs font-semibold rounded-full w-fit"><b>N°
                            :
                        </b>{{ supplierData.document }}
                    </span>



                </div>
                <hr class="mt-3 mb-3" />


                <form @submit.prevent="handleSubmit" class="flex flex-wrap items-start gap-6">

                    <!-- Nombre -->
                    <div class="flex flex-col w-full md:w-48">
                        <label class="text-sm font-medium text-gray-700">Nombre *</label>
                        <input type="text" v-model="form.name" maxlength="50" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base
            focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>

                    <!-- Email -->
                    <div class="flex flex-col w-full md:w-64">
                        <label class="text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" v-model="form.email" maxlength="50" required class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base
            focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>

                    <!-- Teléfono -->
                    <div class="flex flex-col w-full md:w-48">
                        <label class="text-sm font-medium text-gray-700">Teléfono *</label>
                        <input type="text" v-model="form.phone" @input="form.phone = $getFormatInteger($event.target.value)" maxlength="15" required class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base
            focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>

                    <!-- Documento (NIT / CC) -->


                    <!-- País -->
                    <div class="flex flex-col w-full md:w-48">
                        <label class="text-sm font-medium text-gray-700">País *</label>
                        <input type="text" v-model="form.country" required class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base
            focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>


                    <div class="flex flex-col w-full md:w-48">
                        <label class="text-sm font-medium text-gray-700">Ciudad *</label>
                        <input type="text" v-model="form.city" required class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base
            focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>

                    <!-- Dirección -->
                    <div class="flex flex-col w-full md:w-64">
                        <label class="text-sm font-medium text-gray-700">Dirección *</label>
                        <input type="text" v-model="form.address" required class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base
            focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>

                    <!-- Departamento y Ciudad -->




                    <!-- Activo -->
                    <div class="flex flex-col w-24">
                        <div class="flex items-center md:mt-5">
                            <input type="checkbox" v-model="form.active"
                                class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500" />
                            <label class="ml-2 text-sm font-medium text-gray-700">Activo</label>
                        </div>
                    </div>

                </form>


            </div>
        </div>

        <template #footer>
            <div class="flex flex-col md:flex-row gap-4 mt-4">
                <button @click="emit('update:modelValue', false)" type="button" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100
        dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700
        w-full md:w-auto">
                    Cancelar
                </button>
                <button @click="handleSubmit" :disabled="loading" class="flex items-center justify-center
        py-2 px-6 border border-transparent
        rounded-lg shadow-md text-lg font-medium text-white
        bg-green-600 hover:bg-green-700 focus:outline-none
        focus:ring-2 focus:ring-offset-2 focus:ring-green-500
        disabled:opacity-50 transition duration-150
        w-full md:w-auto text-center gradient-button">

                    <svg v-if="loading" class="animate-spin mr-3 h-5 w-5 text-white" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2.01 5.938A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>

                    <svg v-else class="mr-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>

                    <span class="leading-snug whitespace-nowrap text-center">
                        {{ form.id ? (loading ? 'Actualizando Proveedor...' : 'Actualizar Proveedor') :
                            (loading ? 'Registrando Proveedor...' : 'Registrar Proveedor') }}
                    </span>
                </button>
            </div>
        </template>
    </DocumentsRoot>
</template>

<script setup>
import { reactive, ref, watch } from 'vue';
import api from "@/plugins/axios";
import DocumentsRoot from './DocumentsRoot.vue'
import HeaderButtonGenInformComplet from '@/components/HeaderButtonGenInformComplet.vue';
import DepartamentoCiudadSelect from '@/components/DepartamentoCiudadSelect.vue';
import { useAuthStore } from '@/stores/useAuthStore'

const authStore = useAuthStore()

const props = defineProps({
    modelValue: Boolean,
    supplierData: { type: Object, default: null },
    supplierId: [Number, String, null],
});

const emit = defineEmits(['update:modelValue', 'supplier-updated']);

const loading = ref(false);
const successMessage = ref(null);
const errorMessage = ref(null);

// FORMULARIO AJUSTADO A LOS CAMPOS REALES
const form = reactive({
    id: null,
    name: '',
    email: '',
    phone: '',
    address: '',
    city: '',
    country: '',
    document: '',
    company_id: null,
    active: true,
});

// 🔄 Cargar datos cuando se edita
watch(() => props.supplierData, (data) => {
    if (!data) {
        Object.assign(form, {
            id: null,
            name: '', email: '', phone: '',
            address: '', city: '', country: '',
            document: '',
            company_id: props.supplierId ?? null,
            active: true,
        });
        return;
    }

    Object.assign(form, {
        id: data.id,
        name: data.name,
        email: data.email,
        phone: data.phone,
        address: data.address,
        city: data.city,
        country: data.country,
        document: data.document,
        company_id: data.company_id,
        active: data.active == 1,
    });
}, { immediate: true });

watch(() => props.modelValue, (isOpen) => {
    if (isOpen) {
        successMessage.value = null;
        errorMessage.value = null;
    }
});

// ---------------------------------------------
// 🚀 GUARDAR (CREATE / UPDATE)
// ---------------------------------------------
const handleSubmit = async () => {
    // 1. INICIALIZACIÓN Y VALIDACIÓN BÁSICA
    // ------------------------------------
    authStore.loading = true;
    successMessage.value = null;
    errorMessage.value = null;

    const isUpdate = !!form.id; // Verifica si estamos actualizando

    // Si no es una actualización (isUpdate es false), se puede detener la función
    // o redirigirla a una función de creación separada, pero aquí asumimos que siempre es 'update'.
    if (!isUpdate) {
        errorMessage.value = "Error: No se encontró ID para actualizar.";
        authStore.loading = false;
        return;
    }

    // 2. CONFIGURACIÓN DE LA SOLICITUD
    // --------------------------------
    let endpoint = `/admin/suppliers/${form.id}`;
    // 🔑 CLAVE: Usamos 'post' en Axios para asegurar el correcto envío de FormData
    let httpMethod = 'post';

    try {
        const formData = new FormData();

        // 🔑 2.1. Incluir el spoofing: Le dice a Laravel que interprete este POST como PUT
        formData.append('_method', 'PUT');

        // 2.2. Adjuntar los campos del formulario
        for (const key in form) {
            const value = form[key];

            // 🛑 EXCLUIR ID del cuerpo, va en la URL.
            if (key === 'id') continue;

            // Manejar nulos/undefineds
            let finalValue = value === null || value === undefined ? '' : value;

            // Convertir booleanos a 1/0 para el backend (Laravel)
            if (typeof finalValue === 'boolean') {
                finalValue = finalValue ? 1 : 0;
            }

            formData.append(key, finalValue);
        }

        // 3. ENVÍO DE LA PETICIÓN (USANDO POST)
        // ------------------------------------
        const response = await api({
            method: httpMethod, // Ahora es 'post'
            url: endpoint,
            data: formData,
            headers: {
                'Content-Type': 'multipart/form-data', // Asegura el tipo de contenido
            },
        });

        // 4. MANEJO DE ÉXITO
        // ------------------
        successMessage.value = response.data.message ?? 'Proveedor actualizado exitosamente.';

        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Proveedor Actualizado con Éxito!",
            showConfirmButton: false,
            timer: 1500
        });

        emit("supplierUpdated", { // Cambié 'dataUpdated' a 'supplier-updated' por claridad
            success: true,
            supplierId: response.data.supplier?.id ?? form.id,
            data: response.data.supplier
        });

        // Cierra el modal
        emit('update:modelValue', false);

        // El loader se desactiva en el finally

    } catch (error) {
        // 5. MANEJO DE ERROR
        // ------------------
        console.error("Error al actualizar proveedor:", error);
        if (error.response) {
            if (error.response.status === 422) {
                const errors = error.response.data?.data?.errors ?? error.response.data?.errors;
                if (errors) {
                    const firstKey = Object.keys(errors)[0];
                    errorMessage.value = errors[firstKey][0];
                } else {
                    errorMessage.value = error.response.data.message;
                }
            } else if (error.response.data?.message) {
                errorMessage.value = error.response.data.message;
            } else {
                errorMessage.value = `Error del servidor: ${error.response.status}`;
            }
        } else {
            errorMessage.value = "Error de conexión con el servidor.";
        }
        // El loader se desactiva en el finally

    } finally {
        // 6. LIMPIEZA
        // -----------
        loading.value = false;
        authStore.loading = false;
    }
};
</script>




<style scoped>
/* Las clases de estilo proporcionadas no son necesarias para la funcionalidad,
   pero se mantienen si solucionan problemas de layout en otros lugares. */
</style>
