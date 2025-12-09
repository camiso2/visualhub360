<template>
    <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700 ">


        <HeaderButtonGenInformComplet :title="`Registrar Sucursal `" :isDopDownVisible=false>
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
        <!-- Mensajes -->
        <div v-if="successMessage" class="w-full mt-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ successMessage }}
        </div>

        <div class="w-full overflow-x-auto bg-white rounded-xl p-3 border mb-5">

            <div class="mb-6 p-4 border rounded-lg bg-indigo-50  space-y-4">
                <form @submit.prevent="handleSubmit" class="flex flex-wrap items-start gap-6">


                    <!-- Imagen -->
                    <div class="flex flex-col w-64">
                        <label for="branchImage" class="text-sm font-medium text-gray-700">Imagen*</label>
                        <input type="file" id="branchImage" required @change="handleFileUpload" class="mt-1 block w-full text-sm text-gray-500
               file:mr-4 file:py-2 file:px-4 file:rounded-full
               file:border-0 file:text-sm file:font-semibold
               file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition duration-150" />
                    </div>
                    <div class="flex flex-col w-full md:w-64">
                        <label for="branchName" class="text-sm font-medium text-gray-700">Nombre de la Sucursal
                            *</label>
                        <input type="text" id="branchName" v-model="form.name" required
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body" />
                    </div>

                    <div class="flex flex-col w-full md:w-48">
                        <label for="branchEmail" class="text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="branchEmail" v-model="form.email"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body" />
                    </div>

                    <div class="flex flex-col w-full md:w-48">
                        <label for="branchPhone" class="text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" id="branchPhone" v-model="form.phone"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body" />
                    </div>

                    <div class="flex flex-col w-full md:w-64">
                        <label for="branchAddress" class="text-sm font-medium text-gray-700">Dirección</label>
                        <input type="text" id="branchAddress" v-model="form.address"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body" />
                    </div>

                    <DepartamentoCiudadSelect v-model:department="form.department" v-model:city="form.city" />


                    <!-- Activa -->
                    <div class="flex flex-col w-48">
                        <div class="flex items-center">
                            <input id="isActive" type="checkbox" v-model="form.active"
                                class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500" />
                            <label for="isActive" class="ml-2 text-sm font-medium text-gray-700">Sucursal Activa</label>
                        </div>
                    </div>
                    <div class="flex items-end w-full md:w-auto"> <button type="submit" :disabled="loading" class="flex items-center justify-center mt-4
        py-2 px-6 border border-transparent
        rounded-lg shadow-md text-lg font-medium text-white
        bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 transition duration-150
        w-full md:w-auto text-center gradient-button">
                            <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2.01 5.938A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <svg v-else class="-ml-1 mr-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>{{ loading ? 'Registrando Sucursal...' : 'Crear Sucursal' }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <BranchesView ref="branchesViewRef" />
    </div>
</template>


<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/useAuthStore';
import HeaderButtonGenInformComplet from '../components/HeaderButtonGenInformComplet.vue'
import DepartamentoCiudadSelect from '@/components/DepartamentoCiudadSelect.vue';

import BranchesView from './BranchesView.vue'
import api from "@/plugins/axios";

const router = useRouter();
const authStore = useAuthStore();
const successMessage = ref(null);
const loading = ref(false);
const errorMessage = ref(null);


const form = reactive({
    name: '',
    phone: '',
    email: '',
    image: null, // Archivo binario
    address: '',
    city: '',
    department: '',
    active: true, // Por defecto, activa
});

/**
 * Maneja la selección del archivo de imagen.
 */
const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;
    }
};

const branchesViewRef = ref(null);



/**
 * Envía el formulario de la sucursal.
 */
const handleSubmit = async () => {
    loading.value = true;
    errorMessage.value = null;
    successMessage.value = null;
    authStore.loading = true;

    // 1. Obtener el token de autenticación del store (CRÍTICO)
    const token = authStore.token; // Asumiendo que `token` está disponible en tu store

    if (!token) {
        errorMessage.value = 'No se encontró el token de autenticación. Por favor, inicia sesión de nuevo.';
        loading.value = false;
        return;
    }

    // 2. Crear FormData para enviar la imagen y los demás datos
    const formData = new FormData();
    for (const key in form) {
        const value = form[key];
        // Adjuntar el archivo si existe, sino adjuntar el valor normal
        if (value instanceof File) {
            formData.append(key, value, value.name);
        } else if (value !== null && value !== undefined && value !== '') {
            // Convertir booleano a string ('true' o 'false') ya que FormData no maneja booleanos nativos
            formData.append(key, typeof value === 'boolean' ? (value ? '1' : '0') : value);
        }
    }

    try {
        const response = await api.post('/admin/branches', formData);


        // Crear un objeto company temporal
        const branch = response.data.data.branch;



        console.log("response en registro de sucursal  :::", branch)
        // 3. Éxito: La sucursal fue creada.
        successMessage.value = response.data.message || 'Registro de la Sucursal completado con éxito.';

        // Después de crear la sucursal exitosamente:
        if (branchesViewRef.value) {
            branchesViewRef.value.fetchBranches();
        }
        authStore.loading = false;
        // 4. Redirigir al Login
        //alert(`¡Sucursal "${response.data.branch.name}" creada con éxito! Por favor, inicia sesión.`);
        //router.push({ path: '/login' });

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
        authStore.loading = false;
    } finally {
        // 7. Desactivar el Global Loader
        loading.value = false;
        authStore.loading = false;
    }
};
</script>
