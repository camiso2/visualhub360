<template>
    <DocumentsRoot :modelValue="props.modelValue" @update:modelValue="value => emit('update:modelValue', value)"
        title=" " :branch-id="props.branchId">

        <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700 ">

            <HeaderButtonGenInformComplet :title="`Actualizar Datos de Sucursal`" :isDopDownVisible="false">
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
                <div v-if="props.branchData?.image && !form.image" class="mt-2 mb-2">

                    <div @click="$openImageViewer(props.branchData.image || '/avatars/default-avatar.png')"
                        class="w-16 h-16 overflow-hidden rounded-md shadow-md border cursor-pointer group relative">


                        <img :src="props.branchData.image || '/avatars/default-avatar.png'"
                            :alt="props.branchData.image"
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" />

                        <div
                            class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col w-full md:w-64">
                    <label class="text-sm font-medium text-gray-700"> Identificador de la Sucursal</label>
                    <span
                        class="bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300 px-3 py-2 text-xs font-semibold rounded-full w-fit"><b>Código
                            :
                        </b>{{ branchData.code }}
                    </span>

                </div>
                <hr class="mt-3 mb-3" />


                <form @submit.prevent="handleSubmit" class="flex flex-wrap items-start gap-6">

                    <!-- Imagen -->
                    <div class="flex flex-col w-64">
                        <label for="avatar" class="text-sm font-medium text-gray-700">Imagen</label>
                        <input type="file" id="avatar" @change="handleFileUpload" class="mt-1 block w-full text-sm text-gray-500
            file:mr-4 file:py-2 file:px-4 file:rounded-full
            file:border-0 file:text-sm file:font-semibold
            file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition" />

                        <!-- Vista previa si se seleccionó archivo -->
                        <img v-if="imagePreview" :src="imagePreview"
                            class="h-20 w-20 rounded-lg mt-3 object-cover border" />

                        <!-- Imagen actual del backend si no hay preview -->
                        <img v-else-if="form.image && typeof form.image === 'string'" :src="form.image"
                            class="h-20 w-20 rounded-lg mt-3 object-cover border" />
                    </div>


                    <!-- Nombre -->
                    <div class="flex flex-col w-full md:w-66">
                        <label class="text-sm font-medium text-gray-700">Nombre *</label>
                        <input type="text" v-model="form.name" required class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base
                   focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>

                    <!-- Email -->
                    <div class="flex flex-col w-full md:w-48">
                        <label class="text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" v-model="form.email" required class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base
                   focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>

                    <!-- Teléfono -->
                    <div class="flex flex-col w-full md:w-48">
                        <label class="text-sm font-medium text-gray-700">Teléfono *</label>
                        <input type="text" v-model="form.phone"
                            @input="form.phone = $getFormatInteger($event.target.value)" maxlength="12" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base
                   focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>

                    <!-- Dirección -->
                    <div class="flex flex-col w-full md:w-64">
                        <label class="text-sm font-medium text-gray-700">Dirección *</label>
                        <input type="text" v-model="form.address" required class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base
                   focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>
                    <!-- Departamento y ciudad -->
                    <DepartamentoCiudadSelect v-model:department="form.department" v-model:city="form.city" />
                    <!-- Activo -->
                    <div class="flex flex-col w-24">
                        <div class="flex items-center md:mt-5">
                            <input type="checkbox" v-model="form.active"
                                :disabled="props.branchData.code == authStore.user.branch.code"
                                class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500" />
                            <label class="ml-2 text-sm font-medium text-gray-700 ">Activo</label>
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
                        {{ form.id ? (loading ? 'Actualizando Sucursal...' : 'Actualizar Sucursal') :
                            (loading ? 'Registrando Sucursal...' : 'Registrar Sucursal') }}
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

// --- Dependencias externas o estáticas ---
// **NOTA:** Asumo que tienes una forma de cargar los roles, para el ejemplo, los defino estáticamente.
const roles = ref([]);



// ----------------------------------------------------------------------
// 1. PINIA & ESTADO GLOBAL
// ----------------------------------------------------------------------
const authStore = useAuthStore();

// ----------------------------------------------------------------------
// 2. PROPS y EMITS (Ajuste crucial)
// ----------------------------------------------------------------------
const props = defineProps({
    modelValue: Boolean,
    // 🎯 CLAVE: 'branchData' recibe todo el objeto del usuario a editar
    branchData: {
        type: Object,
        default: null
    },

    branchId: [Number, String, null],// Mantenemos el userId por si se usa en DocumentsRoot

    availableRoles: {
        type: Array,
        default: () => []
    }
})

// 🎯 Agregamos un emit para notificar al padre que la data fue actualizada.
const emit = defineEmits(['update:modelValue', 'documentSaved', "branch-registered"])
const router = useRouter();


// ----------------------------------------------------------------------
// 3. ESTADO LOCAL
// ----------------------------------------------------------------------
const loading = ref(false);
const successMessage = ref(null);
const errorMessage = ref(null);

// ----------------------------------------------------------------------
// 4. FORMULARIO REACTIVO (Alineado con el payload del usuario)
// ----------------------------------------------------------------------
const form = reactive({
    id: null,
    name: '',
    email: '',
    phone: '',
    address: '',
    city: '',
    department: '',
    document_type: '',
    document_number: '',
    branch_id: null,
    // Se usa 'role_name' en el <select>, pero el backend puede esperar 'role_id'
    role_name: '', // Para el select
    role_id: null, // Para el payload (si el backend lo requiere, ajustar handleSubmit)
    password: '',
    active: true, // Si es 1 o 0 en el backend, usar booleano o 1/0
    image: null // Archivo de imagen para subir
});

watch(
    () => props.availableRoles,
    (newRoles) => {
        roles.value = newRoles || [];
    },
    { immediate: true }
);


// ----------------------------------------------------------------------
// 5. LÓGICA DE CARGA DE DATOS DEL USUARIO (WATCHER)
// ----------------------------------------------------------------------
watch(() => props.branchData, (newbranchData) => {

    // Si newbranchData es null o undefined, prepara para un NUEVO REGISTRO
    if (!newbranchData || !newbranchData.id) {
        Object.assign(form, {
            id: null,
            name: '',
            email: '',
            phone: '',
            address: '',
            city: '',
            department: '',
            document_type: 'CC', // Establecer un valor por defecto
            document_number: '',
            branch_id: authStore.branch?.branch_id ?? null,
            role_name: '',
            role_id: null,
            password: '',
            active: true,
            image: null,
        });
        console.log('Formulario limpiado para un nuevo registro de usuario.');
        return;
    }

    // Mapear los datos del usuario (newbranchData) al formulario (form)
    Object.assign(form, {
        id: newbranchData.id,
        name: newbranchData.name ?? '',
        email: newbranchData.email ?? '',
        phone: newbranchData.phone ?? '',
        address: newbranchData.address ?? '',
        city: newbranchData.city ?? '',
        department: newbranchData.department ?? '',
        document_type: newbranchData.document_type ?? 'CC',
        document_number: newbranchData.document_number ?? '',
        branch_id: newbranchData.branch_id ?? authStore.branch?.branch_id ?? null,
        // Usamos el rol del objeto si está disponible, o el ID
        role_name: newbranchData.roles?.[0]?.name ?? '', role_id: newbranchData.role_id ?? null,
        password: '', // Importante: no precargar contraseñas
        active: !!newbranchData.active,
        image: null, // El archivo siempre debe ser null hasta que se seleccione uno nuevo
    });

    console.log('Formulario precargado para el Usuario ID:', form.id);
}, { immediate: true });
watch(() => props.modelValue, (isOpen) => {
    if (isOpen) {
        // El modal se abrió → limpiar mensajes
        successMessage.value = null;
        errorMessage.value = null;
    }
});

// ----------------------------------------------------------------------
// 6. MANEJADORES DE EVENTOS Y SUBMIT
// ----------------------------------------------------------------------
const imagePreview = ref(null);
const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;
        imagePreview.value = URL.createObjectURL(file);

    }
};

const handleSubmit = async () => {
    authStore.loading = true; // Activa el Global Loader
    loading.value = true;
    errorMessage.value = null;
    successMessage.value = null;

    // 1. Determinar el método y el endpoint
    const isUpdate = !!form.id;
    /* let endpoint = isUpdate ? `/admin/branches/${form.id}` : '/admin/branches/'; // Ajusta el endpoint de creación si es diferente
     let httpMethod = isUpdate ? 'post' : 'post'; // Se usa POST con FormData/multipart*/

    // 2. Preparar FormData
    const formDataPayload = new FormData();

    for (const key in form) {
        const value = form[key];

        // Excluir campos no necesarios o vacíos, o ajustar el valor para el backend
        if (key === 'id' || key === 'role_name') continue; // ID es parte del endpoint, role_name es solo para el select

        // Si es una actualización y la contraseña está vacía, no la enviamos.
        if (isUpdate && key === 'password' && !value) continue;

        // Si el valor es null/undefined, envíalo como string vacío o ajusta a tu backend
        const finalValue = value instanceof File ? value : (value === null || value === undefined ? '' : value);
        formDataPayload.append(key, finalValue);
    }




    try {
        // 3. Enviar la petición
        const response = await api.post(`/admin/branches/${form.id}`, formDataPayload);

        // 4. Manejo de éxito
        successMessage.value = response.data.message ?? (isUpdate ? 'Usuario actualizado exitosamente.' : 'Usuario registrado exitosamente.');

        // Notificación de éxito
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: isUpdate ? "Usuario Actualizado con éxito!" : "Usuario Registrado con éxito!",
            showConfirmButton: false,
            timer: 1500
        });

        // 5. Emitir evento de actualización/registro
        emit("dataUpdated", {
            success: true,
            branchId: response.data.branch?.id ?? form.id,
            data: response.data.branch
        });

        // Cierra el modal después de la operación exitosa
        emit('update:modelValue', false);

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


<style scoped>
/* Las clases de estilo proporcionadas no son necesarias para la funcionalidad,
   pero se mantienen si solucionan problemas de layout en otros lugares. */
</style>
