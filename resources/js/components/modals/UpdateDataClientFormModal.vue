<template>
    <DocumentsRoot :modelValue="props.modelValue" @update:modelValue="value => emit('update:modelValue', value)"
        title=" " :client-id="props.clientId">

        <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700 ">

            <HeaderButtonGenInformComplet :title="form.id ? `Actualizar Datos Cliente` : `Registrar Cliente`"
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
                    <label class="text-sm font-medium text-gray-700"> Documento Identificación Cliente</label>
                    <span
                        class="bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300 px-3 py-2 text-xs font-semibold rounded-full w-fit"><b>N°
                        </b> {{ clientData.document_number }}</span>

                </div>
                <hr class="mt-3 mb-3" />


                <form @submit.prevent="handleSubmit" class="flex flex-wrap items-start gap-6">
                    <div class="flex flex-col md:flex-row w-full gap-4">
                        <div class="flex flex-col w-full md:w-77">
                            <label class="text-sm font-medium text-gray-700">Nombre *</label>
                            <input type="text" v-model="form.name" required
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                        </div>

                        <div class="flex flex-col w-full md:w-63">
                            <label class="text-sm font-medium text-gray-700">Tipo de Documento *</label>
                            <select v-model="form.document_type" required
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2.5 shadow-xs">
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
                    </div>



                    <div class="flex flex-col w-full md:w-64">
                        <label class="text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" v-model="form.email" required
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>

                    <div class="flex flex-col w-full md:w-48">
                        <label class="text-sm font-medium text-gray-700">Teléfono *</label>
                        <input type="text" v-model="form.phone" @input="form.phone = $getFormatInteger($event.target.value)" maxlength="12" required
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>
                    <DepartamentoCiudadSelect v-model:department="form.department" v-model:city="form.city" />


                    <div class="flex flex-col w-full md:w-64">
                        <label class="text-sm font-medium text-gray-700">Dirección *</label>
                        <input type="text" v-model="form.address" required
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>




                    <div class="flex flex-col w-full md:w-24">
                        <div class="flex items-center h-full">
                            <input type="checkbox" v-model="form.active"
                                class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500" />
                            <label class="ml-2 text-sm font-medium text-gray-700">Activo</label>
                        </div>
                    </div>

                    <div class="flex items-end w-full md:w-auto">

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
                        {{ loading ? (form.id ? 'Actualizando Cliente...' : 'Registrando Cliente...') :
                            (form.id ? 'Actualizar Cliente' : 'Registrar Cliente') }}
                    </span>
                </button>
            </div>
        </template>
    </DocumentsRoot>
</template>

<script setup>
import { reactive, ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import HeaderButtonGenInformComplet from '@/components/HeaderButtonGenInformComplet.vue';
import DepartamentoCiudadSelect from '@/components/DepartamentoCiudadSelect.vue';
import api from "@/plugins/axios";
import DocumentsRoot from './DocumentsRoot.vue'
import { useAuthStore } from '@/stores/useAuthStore'

// --- Omisión de imports/setup innecesarios ---

// ----------------------------------------------------------------------
// 1. PINIA & ESTADO GLOBAL
// ----------------------------------------------------------------------
const authStore = useAuthStore();
// console.log('branch_id : ' + (authStore.user?.branch_id ?? 'Cargando...'))

// ----------------------------------------------------------------------
// 2. PROPS y EMITS (Ajuste crucial)
// ----------------------------------------------------------------------
const props = defineProps({
    modelValue: Boolean,
    // 🎯 CLAVE: 'clientData' debe recibir TODO el objeto del cliente.
    clientData: {
        type: Object,
        default: null
    },


    // Eliminamos 'clientId' ya que 'clientData' lo contiene (como 'id')
})

// 🎯 Agregamos un emit para notificar al padre que la data fue actualizada.
const emit = defineEmits(['update:modelValue', 'documentSaved', "client-registered", "dataUpdated"])
const router = useRouter();


// ----------------------------------------------------------------------
// 3. ESTADO LOCAL
// ----------------------------------------------------------------------
const loading = ref(false);
const successMessage = ref(null);
const errorMessage = ref(null);


// ----------------------------------------------------------------------
// 4. FORMULARIO REACTIVO
// ----------------------------------------------------------------------
const form = reactive({
    // ID del cliente (CLAVE: null para registro, el ID para edición)
    id: null,
    name: '',
    email: '',
    phone: '',
    address: '',
    city: '',
    department: '',
    document_type: '',
    // document_number: '',
    branch_id: authStore.user?.branch_id ?? null,
    active: true,
    avatar: null
});

// ----------------------------------------------------------------------
// 5. LÓGICA DE CARGA DE DATOS DEL CLIENTE (WATCHER)
// ----------------------------------------------------------------------
// 🎯 El watcher es el corazón de la edición: carga los datos cuando 'clientData' cambia.
watch(() => props.clientData, (newClientData) => {

    console.log('clientData :: ', props.clientData)
    // Si newClientData es null o undefined, limpia el formulario (prepara para un nuevo registro)
    if (!newClientData) {
        // Establecer valores por defecto (vacíos o null)
        Object.keys(form).forEach(key => {
            if (key === 'active') {
                form[key] = true;
            } else if (key === 'branch_id') {
                form[key] = authStore.user?.branch_id ?? null;
            } else {
                form[key] = null;
            }
        });
        // Asegurar que el id esté en null para indicar que es un registro
        form.id = null;
        console.log('Formulario limpiado para un nuevo registro.');
        return;
    }

    // Mapear los datos del cliente (newClientData) al formulario (form)
    form.id = newClientData.id;
    form.name = newClientData.name;
    form.email = newClientData.email;
    form.phone = newClientData.phone;
    form.address = newClientData.address;
    form.city = newClientData.city;
    form.department = newClientData.department;
    form.document_type = newClientData.document_type;
    // form.document_number = newClientData.document_number;
    form.active = !!newClientData.active;
    //form.branch_id = newClientData.branch_id ?? authStore.user?.branch_id ?? null;

    // El avatar solo se usa para subir un nuevo archivo, no para precargar
    form.avatar = null;

    console.log('Formulario precargado para el cliente ID:', form.id);
}, { immediate: true });


// ----------------------------------------------------------------------
// 6. MANEJADORES DE EVENTOS Y SUBMIT
// ----------------------------------------------------------------------

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.avatar = file;
    }
};

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
        // Solo agregar el ID si estamos actualizando
        if (key === 'id' && !value) continue;
        formData.append(key, value instanceof File ? value : value ?? '');
    }
    try {
        // Usamos POST para manejar FormData, incluso para las actualizaciones (común en Laravel)
        const response = await api.post(`/clients/update/${form.id}`, formData);
        successMessage.value = response.data.message ?? (isUpdate ? 'Cliente actualizado exitosamente.' : 'Cliente registrado exitosamente.');

        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Cliente Actualizado con éxito !",
            showConfirmButton: false,
            timer: 1500
        });
        // 🎯 Emitir un evento general de actualización
        emit("dataUpdated", {
            success: true,
            clientId: form.id,
            data: response.data.client // Si el backend devuelve el cliente actualizado
        });
        // También emitimos el evento 'client-registered' (el nombre es un poco ambiguo pero lo mantengo)
        emit("client-registered", {
            success: true,
            document_number: form.document_number
        });
        // Cierra el modal después de la operación exitosa
        emit('update:modelValue', false);
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
/* Selecciona la clase del formulario */
.form-full-width {
    /* Desactiva el envoltorio (flex-wrap) si está aplicado */
    flex-wrap: nowrap;

    /* Cambia la dirección del flex a columna para que los elementos se apilen */
    flex-direction: column;

    /* Ajusta el espaciado vertical entre elementos (si es necesario) */
    gap: 1rem;
    /* 16px */
}

/* Fuerza a que los contenedores hijos (donde están los inputs) ocupen todo el ancho disponible */
.form-full-width>div {
    width: 100% !important;
    /* El !important se usa para anular las clases de Tailwind (md:w-XX) */
    max-width: none !important;
}
</style>
