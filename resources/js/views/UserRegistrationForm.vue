<template>
    <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700 ">



        <HeaderButtonGenInformComplet :title="`Registrar Colaborador`" :isDopDownVisible=false>
            <template #icon>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 3a.75.75 0 00-.75.75V1.5h-1.5a.75.75 0 00-.75.75V3H9.75V1.5a.75.75 0 00-.75-.75H7.5a.75.75 0 00-.75.75V3H6.75A.75.75 0 006 3.75v16.5c0 .414.336.75.75.75h10.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75H15.75zM12 12h.008v.008H12V12zM12 16h.008v.008H12V16zM15.75 8.25V6.75a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0zM8.25 8.25V6.75a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0z" />
                </svg>
            </template>
        </HeaderButtonGenInformComplet>

        <!-- Error -->
        <div v-if="errorMessage" class="w-full bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded text-sm">
            <p class="font-semibold">Error:</p>
            <p>{{ errorMessage }}</p>
        </div>

        <!-- Exito -->
        <div v-if="successMessage" class="w-full mt-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ successMessage }}
        </div>
        <div class="w-full overflow-x-auto bg-white rounded-xl p-3 border mb-5">
            <div class="mb-6 p-4 border rounded-lg bg-indigo-50  space-y-4">
                <form @submit.prevent="handleSubmit" class="flex flex-wrap items-start gap-6">
                    <!-- Avatar -->
                    <div class="flex flex-col w-64">
                        <label for="avatar" class="text-sm font-medium text-gray-700">Avatar (Imagen)</label>
                        <input type="file" id="avatar" @change="handleFileUpload" required class="mt-1 block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4 file:rounded-full
                            file:border-0 file:text-sm file:font-semibold
                            file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition duration-150" />
                    </div>

                    <!-- Nombre -->
                    <div class="flex flex-col w-full md:w-64">
                        <label class="text-sm font-medium text-gray-700">Nombre *</label>
                        <input type="text" v-model="form.name" required
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>

                    <!-- Email -->
                    <div class="flex flex-col w-full md:w-64">
                        <label class="text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" v-model="form.email" required
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>
                    <!-- Teléfono -->
                    <div class="flex flex-col w-full md:w-48">
                        <label class="text-sm font-medium text-gray-700">Teléfono *</label>
                        <input type="text" v-model="form.phone" @input="form.phone = $getFormatInteger($event.target.value)" required maxlength="12"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>
                    <!-- Dirección -->
                    <div class="flex flex-col w-full md:w-64">
                        <label class="text-sm font-medium text-gray-700">Dirección *</label>
                        <input type="text" v-model="form.address" required
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>
                    <!-- Ciudad -->
                    <DepartamentoCiudadSelect v-model:department="form.department" v-model:city="form.city" />
                    <!-- Tipo Documento -->
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
                    <!-- Número Documento -->
                    <div class="flex flex-col w-full md:w-64">
                        <label class="text-sm font-medium text-gray-700">Número de Documento *</label>
                        <input type="text" v-model="form.document_number" @input="form.document_number = $getFormatInteger($event.target.value)" required maxlength="12"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>
                    <!-- Contraseña -->
                    <div class="flex flex-col w-full md:w-64">
                        <label class="text-sm font-medium text-gray-700">Contraseña *</label>
                        <input type="password" v-model="form.password" required
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                    </div>
                    <!-- Rol -->
                    <div class="flex flex-col w-full md:w-64">
                        <label class="text-sm font-medium text-gray-700">Rol *</label>

                        <select v-model="form.role_name" required
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs">

                            <option disabled value="">Seleccione un rol...</option>

                            <option v-for="role in roles" :key="role.name" :value="role.name">
                                {{ role.name }}
                            </option>
                        </select>
                    </div>
                    <!-- Activo -->
                    <div class="flex flex-col w-24">
                        <div class="flex items-center">
                            <input type="checkbox" v-model="form.active"
                                class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500" />
                            <label class="ml-2 text-sm font-medium text-gray-700">Activo</label>
                        </div>
                    </div>
                    <!-- Botón Registrar -->
                    <div class="flex items-end w-full md:w-auto">
                        <button type="submit" :disabled="loading" class="flex items-center justify-center mt-4
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
                            <span>{{ loading ? 'Registrando Colaborador...' : 'Registrar Colaborador' }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <UsersView ref="UsersViewRef" />
    </div>
</template>




<script setup>
import { reactive, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
//import axios from 'axios';
import { useAuthStore } from '@/stores/useAuthStore';
import HeaderButtonGenInformComplet from '../components/HeaderButtonGenInformComplet.vue';
import UsersView from './UsersView.vue';
import api from '@/plugins/axios'
import DepartamentoCiudadSelect from '@/components/DepartamentoCiudadSelect.vue';


const router = useRouter();
const authStore = useAuthStore();

const successMessage = ref(null);
const loading = ref(false);
const errorMessage = ref(null);

const roles = ref([]);
onMounted(() => {
    fetchRoles();
});
const fetchRoles = async () => {
    try {
        const response = await api.get('/roles');
        roles.value = response.data.data.roles;
        console.log('Roles cargados:', roles.value);

    } catch (error) {
        console.error('Error al cargar roles:', error);
    }
};
console.log('branch_id : ' + authStore.user.branch_id)

// FORMULARIO PRINCIPAL
const form = reactive({
    name: '',
    email: '',
    phone: '',
    address: '',
    city: '',
    department: '',
    document_type: '',
    document_number: '',
    password: '',
    role_name: '',
    branch_id: authStore.user.branch_id,   // ← SETEADO CORRECTAMENTE
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

const UsersViewRef = ref(null);

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
        formData.append(key, value instanceof File ? value : value ?? '');
    }

    try {

        const response = await api.post('/admin/createUser', formData);
        console.log('valor a recibido  :: ', response.data)

        successMessage.value = response.data.message ?? 'Colaborador registrado.';

        console.log('recibe lo siguien', response.data)

        if (UsersViewRef.value) {
            UsersViewRef.value.fetchUsers();
        }

        authStore.loading = false;
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Colaborador de la empresa Registrado con Éxito !",
            showConfirmButton: false,
            timer: 1500
        });

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
