<template>
    <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700 ">

        <HeaderButtonGenInformComplet :title="`Registrar Cliente`" :isDopDownVisible=false>
            <template #icon>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8.25v-2.5m0 0c0-.69-.56-1.25-1.25-1.25H6.25A1.25 1.25 0 005 4.75v14.5c0 .69.56 1.25 1.25 1.25h4.5c.69 0 1.25-.56 1.25-1.25v-2.5m0-12.5h3.5c.69 0 1.25.56 1.25 1.25v3.5m-4.75 7.25h6.5c.69 0 1.25-.56 1.25-1.25V9.75L15.5 6H12m0 8.25H9.75m2.25 3H9.75" />
                </svg>
            </template>
        </HeaderButtonGenInformComplet>
        <div v-if="errorMessage" class="w-full bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded text-sm">
            <p class="font-semibold">Error:</p>
            <p>{{ errorMessage }}</p>
        </div>
        <div v-if="successMessage" class="w-full mt-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ successMessage }}
        </div>
        <div class="w-full overflow-x-auto border rounded-lg bg-indigo-50 rounded-xl p-3 border mb-5">
            <form @submit.prevent="handleSubmit" class="flex flex-wrap items-start gap-6">
                <!-- <div class="flex flex-col w-full md:w-64">
                    <label for="avatar" class="text-sm font-medium text-gray-700">Avatar (Imagen)</label>
                    <input type="file" id="avatar" @change="handleFileUpload" class="mt-1 block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4 file:rounded-full
                            file:border-0 file:text-sm file:font-semibold
                            file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition duration-150" />
                </div>-->
                <div class="flex flex-col w-full md:w-64">
                    <label class="text-sm font-medium text-gray-700">Nombre *</label>
                    <input type="text" v-model="form.name" required
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                </div>
                <div class="flex flex-col w-full md:w-48">
                    <label class="text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" v-model="form.email" required
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                </div>
                <div class="flex flex-col w-full md:w-48">
                    <label class="text-sm font-medium text-gray-700">Teléfono *</label>
                    <input type="text" v-model="form.phone" @input="form.phone = $getFormatInteger($event.target.value)"required
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                </div>
                <div class="flex flex-col w-full md:w-64">
                    <label class="text-sm font-medium text-gray-700">Dirección *</label>
                    <input type="text" v-model="form.address" required
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                </div>
                <DepartamentoCiudadSelect v-model:department="form.department" v-model:city="form.city" />
                <div class="flex flex-col w-full md:w-48">
                    <label class="text-sm font-medium text-gray-700">Tipo de Documento *</label>

                    <select v-model="form.document_type" required
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs">

                        <option disabled value="">Seleccione...</option>
                        <option value="CC">Cédula de Ciudadanía (CC)</option>
                        <option value="CE">Cédula de Extranjería (CE)</option>
                        <option value="TI">Tarjeta de Identidad (TI)</option>
                        <option value="PS">Pasaporte (PS)</option>
                        <option value="PEP">PEP - Permiso Especial de Permanencia</option>
                        <option value="PPT">PPT - Permiso por Protección Temporal</option>
                        <option value="NIT">NIT</option>
                    </select>
                </div>
                <div class="flex flex-col w-full md:w-48">
                    <label class="text-sm font-medium text-gray-700">Número de Documento *</label>
                    <input type="text" v-model="form.document_number" @input="form.document_number = $getFormatInteger($event.target.value)"required
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                </div>

                <div class="flex flex-col w-full md:w-24">
                    <div class="flex items-center h-full">
                        <input type="checkbox" v-model="form.active"
                            class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500" />
                        <label class="ml-2 text-sm font-medium text-gray-700">Activo</label>
                    </div>
                </div>

                <div class="flex items-end w-full md:w-auto"> <button type="submit" :disabled="loading" class="flex items-center justify-center mt-4
        py-2 px-6 border border-transparent
        rounded-lg shadow-md text-lg font-medium text-white
        bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 transition duration-150
        w-full md:w-auto text-center gradient-button"> <svg v-if="loading" class="animate-spin mr-3 h-5 w-5 text-white"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2.01 5.938A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>

                        <svg v-else class="mr-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>

                        <span class="leading-snug whitespace-nowrap text-center">
                            {{ loading ? 'Registrando Cliente...' : 'Registrar Cliente' }}
                        </span>

                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
//import axios from 'axios';

import { useAuthStore } from '@/stores/useAuthStore';
import HeaderButtonGenInformComplet from '../components/HeaderButtonGenInformComplet.vue';
import DepartamentoCiudadSelect from '@/components/DepartamentoCiudadSelect.vue';

import api from "@/plugins/axios";

const emit = defineEmits(["client-registered"]);


const router = useRouter();
const authStore = useAuthStore();

const successMessage = ref(null);
const loading = ref(false);
const errorMessage = ref(null);

// Ajusta la URL de la API según el endpoint de registro de clientes
//const API_BASE_URL = 'http://localhost:8000/api';
//const API_CLIENT_ENDPOINT = '/regiterClient'; // O el endpoint correcto para crear clientes

console.log('branch_id : ' + authStore.user.branch_id)

// FORMULARIO PRINCIPAL - Campos adaptados a la estructura del Cliente
const form = reactive({
    name: '',
    email: '',
    phone: '',
    address: '',
    city: '',
    department: '',
    document_type: '',
    document_number: '',
    // Se eliminó 'password'
    // Se eliminó 'role_name'
    branch_id: authStore.user.branch_id, // Se mantiene, asumiendo que se registra en la sucursal del usuario logueado
    active: true,
    avatar: null
});

// MANEJO DE ARCHIVO
const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.avatar = file;
    }
};


// SUBMIT
const handleSubmit = async () => {
    authStore.loading = true;
    errorMessage.value = null;
    successMessage.value = null;

    const token = authStore.token;

    if (!token) {
        errorMessage.value = 'No se encontró el token de autenticación.';
        loading.value = false;
        return;
    }

    const formData = new FormData();
    for (const key in form) {
        const value = form[key];
        // Aseguramos que solo se envíen campos definidos en 'form'
        formData.append(key, value instanceof File ? value : value ?? '');
    }

    // Si necesitas enviar un 'id' de la compañía, puedes agregarlo aquí si no está implícito
    // formData.append('company_id', authStore.user.company_id);


    try {
        /*const response = await axios.post(
            `${API_BASE_URL}${API_CLIENT_ENDPOINT}`, // Nueva ruta para registrar clientes
            formData,
            { headers: { 'Content-Type': 'multipart/form-data', Authorization: `Bearer ${token}` } }
        );*/

        const response = await api.post('/regiterClient', formData);



        successMessage.value = response.data.message ?? 'Cliente registrado exitosamente.';

        emit("client-registered", {
            success: true,
            document_number: form.document_number
        });


        console.log('Cliente registrado', response.data);
        authStore.loading = false;


    } catch (error) {
        console.log(error)
        if (error.response) {
            // ERRORES 422 VALIDACIÓN
            if (error.response.status === 422) {
                const errors = error.response.data?.data?.errors
                    ?? error.response.data?.errors;

                if (errors) {
                    const firstKey = Object.keys(errors)[0];
                    errorMessage.value = errors[firstKey][0];
                } else {
                    errorMessage.value = error.response.data.message;
                }

                // ERRORES 4XX-5XX PERSONALIZADOS
            } else if (error.response.data?.message) {
                errorMessage.value = error.response.data.message;

            } else {
                errorMessage.value = `Error del servidor: ${error.response.status}`;
            }

        } else {
            errorMessage.value = "Error de conexión con el servidor.";
        }
        authStore.loading = false;
    } finally {
        loading.value = false;
        authStore.loading = false;
    }
};
</script>

<style scoped>
/* Tu estilo Tailwind */
</style>
