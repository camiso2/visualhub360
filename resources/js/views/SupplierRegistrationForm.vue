<template>
    <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700 ">


        <HeaderButtonGenInformComplet :title="`Registrar Proveedor`" :isDopDownVisible = false>
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8.25v-2.5m0 0c0-.69-.56-1.25-1.25-1.25H6.25A1.25 1.25 0 005 4.75v14.5c0 .69.56 1.25 1.25 1.25h4.5c.69 0 1.25-.56 1.25-1.25v-2.5m0-12.5h3.5c.69 0 1.25.56 1.25 1.25v3.5m-4.75 7.25h6.5c.69 0 1.25-.56 1.25-1.25V9.75L15.5 6H12m0 8.25H9.75m2.25 3H9.75" />
                    </svg>

                </template>
            </HeaderButtonGenInformComplet>

        <div class="w-full overflow-x-auto bg-white rounded-xl p-3 border mb-5">
<div class="mb-6 p-4 border rounded-lg bg-indigo-50  space-y-4">
            <form @submit.prevent="handleSubmit" class="flex flex-wrap items-start gap-6">

                <!-- Error -->
                <div v-if="errorMessage"
                    class="w-full bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded text-sm">
                    <p class="font-semibold">Error:</p>
                    <p>{{ errorMessage }}</p>
                </div>

                <!-- Exito -->
                <div v-if="successMessage" class="w-full mt-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ successMessage }}
                </div>

                <!-- Nombre -->
                <div class="flex flex-col w-full md:w-64">
                    <label class="text-sm font-medium text-gray-700">Nombre *</label>
                    <input type="text" v-model="form.name" required
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                </div>

                <!-- Email -->
                <div class="flex flex-col w-full md:w-48">
                    <label class="text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" v-model="form.email" required
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                </div>

                <!-- Teléfono -->
                <div class="flex flex-col w-full md:w-48">
                    <label class="text-sm font-medium text-gray-700">Teléfono *</label>
                    <input type="text" v-model="form.phone" @input="form.phone = $getFormatInteger($event.target.value)" required
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                </div>

                <!-- Dirección -->
                <div class="flex flex-col w-full md:w-64">
                    <label class="text-sm font-medium text-gray-700">Dirección *</label>
                    <input type="text" v-model="form.address" required
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                </div>

                <!-- Ciudad -->
                <div class="flex flex-col w-full md:w-48">
                    <label class="text-sm font-medium text-gray-700">Ciudad *</label>
                    <input type="text" v-model="form.city" required
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                </div>

                <!-- País -->
                <div class="flex flex-col w-full md:w-48">
                    <label class="text-sm font-medium text-gray-700">País *</label>
                    <input type="text" v-model="form.country" required
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                </div>

                <!-- Documento -->
                <div class="flex flex-col w-full md:w-48">
                    <label class="text-sm font-medium text-gray-700">Documento</label>
                    <input type="text" v-model="form.document" placeholder="Opcional"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                </div>

                <!-- Activo -->
                <div class="flex flex-col w-48">
                    <div class="flex items-center">
                        <input type="checkbox" v-model="form.active"
                            class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500" />
                        <label class="ml-2 text-sm font-medium text-gray-700">Activo</label>
                    </div>
                </div>

                <!-- Botón Registrar -->
                <div class="flex items-end w-full md:w-auto"></div>
                <div class="flex items-end w-34">
                    <button type="submit" :disabled="loading" class="flex items-center justify-center mt-4
        py-2 px-6 border border-transparent
        rounded-lg shadow-md text-lg font-medium text-white
        bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 transition duration-150
        w-full md:w-auto text-center gradient-button">

                        <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2.01 5.938A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>

                        <svg v-else class="-ml-1 mr-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>

                        <span>{{ loading ? 'Registrando Proveedor...' : 'Registrar Proveedor' }}</span>

                    </button>
                </div>

            </form>
        </div>
        </div>
        <SuppliersView ref="SuppliersViewRef" />
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
//import axios from 'axios';
import { useAuthStore } from '@/stores/useAuthStore';
import HeaderButtonGenInformComplet from '../components/HeaderButtonGenInformComplet.vue';
import SuppliersView from './SuppliersView.vue';
import api from "@/plugins/axios";

const authStore = useAuthStore();
const successMessage = ref(null);
const loading = ref(false);
const errorMessage = ref(null);

const SuppliersViewRef = ref(null);

// FORMULARIO PRINCIPAL
const form = reactive({
    name: '',
    document: '',
    email: '',
    phone: '',
    address: '',
    city: '',
    country: '',
    active: true,

});

// SUBMIT
const handleSubmit = async () => {
    loading.value = true;
    errorMessage.value = null;
    successMessage.value = null;
    authStore.loading = true;

    const token = authStore.token;

    if (!token) {
        errorMessage.value = 'No se encontró el token de autenticación.';
        loading.value = false;
        return;
    }

    const formData = new FormData();
    for (const key in form) {
        const value = form[key];
        formData.append(key, value ?? '');
    }

    try {
        const response = await api.post('/admin/suppliers', formData);
        successMessage.value = response.data.message ?? 'Proveedor registrado.';
        console.log('Respuesta:', response.data);


        if (SuppliersViewRef.value) {
            SuppliersViewRef.value.fetchSuppliers();
        }

        authStore.loading = false;

    } catch (error) {
        // 6. Manejo de error
        console.error("Error en la operación de usuario:", error);
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
    } finally {
        // 7. Desactivar el Global Loader
        loading.value = false;
        authStore.loading = false;
    }
};
</script>
