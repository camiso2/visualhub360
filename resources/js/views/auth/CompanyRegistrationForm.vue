<template>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center p-6 sm:p-12">
        <div class="w-full max-w-4xl bg-white shadow-2xl rounded-xl p-8 sm:p-10 border border-indigo-100">
            <h1 class="text-4xl font-extrabold text-indigo-700 mb-2 text-center">
                Registro de Nueva Empresa
            </h1>
            <p class="text-center text-gray-500 mb-6">
                Paso {{ currentStep }} de 3: Complete los datos
            </p>

            <div class="mb-8">
                <div class="h-2 bg-gray-200 rounded-full">
                    <div class="h-full bg-indigo-500 rounded-full transition-all duration-500"
                        :style="{ width: progressWidth }">
                    </div>
                </div>
                <div class="flex justify-between text-xs text-gray-500 mt-2">
                    <span>Admin</span>
                    <span>Empresa</span>
                    <span>Configuración</span>
                </div>
            </div>

            <div v-if="validationError" class="mt-4 p-4 bg-red-100 text-red-700 rounded-lg mb-4 text-sm">
                {{ validationError }}
            </div>

            <form @submit.prevent="currentStep === totalSteps ? handleSubmit() : null" class="space-y-8">

                <section v-show="currentStep === 1" class="border border-gray-200 p-6 rounded-lg bg-indigo-50/50">
                    <h2 class="text-2xl font-bold text-indigo-600 mb-5 border-b pb-2">
                        👤 Datos del Administrador
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label for="userName" class="block text-sm font-medium text-gray-700">Nombre Completo *</label>
                            <input type="text" id="userName" v-model="form.user.name" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div>
                            <label for="userEmail" class="block text-sm font-medium text-gray-700">Email *</label>
                            <input type="email" id="userEmail" v-model="form.user.email" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div>
                            <label for="userPassword" class="block text-sm font-medium text-gray-700">Contraseña *</label>
                            <input type="password" id="userPassword" v-model="form.user.password" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div>
                            <label for="userPhone" class="block text-sm font-medium text-gray-700">Teléfono *</label>
                            <input type="text" id="userPhone" v-model="form.user.phone" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div>
                            <label for="documentType" class="block text-sm font-medium text-gray-700">Tipo de Documento *</label>
                            <select id="documentType" v-model="form.user.document_type" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="" disabled>Selecciona uno</option>
                                <option value="CC">Cédula de Ciudadanía (CC)</option>
                                <option value="CE">Cédula de Extranjería (CE)</option>
                                <option value="NIT">NIT</option>
                            </select>
                        </div>

                        <div>
                            <label for="documentNumber" class="block text-sm font-medium text-gray-700">Número de Documento *</label>
                            <input type="text" id="documentNumber" v-model="form.user.document_number" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div class="md:col-span-2">
                            <label for="userAvatar" class="block text-sm font-medium text-gray-700">Avatar (Imagen)</label>
                            <input type="file" id="userAvatar" @change="handleFileUpload($event, 'user', 'avatar')"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                        </div>

                        <div class="md:col-span-2">
                            <label for="userAddress" class="block text-sm font-medium text-gray-700">Dirección *</label>
                            <input type="text" id="userAddress" v-model="form.user.address" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div>
                            <label for="userCity" class="block text-sm font-medium text-gray-700">Ciudad *</label>
                            <input type="text" id="userCity" v-model="form.user.city" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>
                        <div>
                            <label for="userDepartment" class="block text-sm font-medium text-gray-700">Departamento *</label>
                            <input type="text" id="userDepartment" v-model="form.user.department" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                    </div>
                </section>

                <section v-show="currentStep === 2" class="border border-gray-200 p-6 rounded-lg bg-white">
                    <h2 class="text-2xl font-bold text-indigo-600 mb-5 border-b pb-2">
                        🏢 Información de la Empresa
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <div class="md:col-span-2">
                            <label for="companyName" class="block text-sm font-medium text-gray-700">Nombre Comercial *</label>
                            <input type="text" id="companyName" v-model="form.company.name" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div>
                            <label for="legalName" class="block text-sm font-medium text-gray-700">Razón Social</label>
                            <input type="text" id="legalName" v-model="form.company.legal_name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div>
                            <label for="companyDocType" class="block text-sm font-medium text-gray-700">Tipo Doc. (Empresa)</label>
                            <select id="companyDocType" v-model="form.company.document_type"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="" disabled>Selecciona uno</option>
                                <option value="NIT">NIT</option>
                                <option value="ID">Otro</option>
                            </select>
                        </div>

                        <div>
                            <label for="companyDocNumber" class="block text-sm font-medium text-gray-700">Número Documento</label>
                            <input type="text" id="companyDocNumber" v-model="form.company.document_number"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div>
                            <label for="dv" class="block text-sm font-medium text-gray-700">Dígito Verificación (DV)</label>
                            <input type="text" id="dv" v-model="form.company.dv" maxlength="1"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div>
                            <label for="companyEmail" class="block text-sm font-medium text-gray-700">Email Empresarial *</label>
                            <input type="email" id="companyEmail" v-model="form.company.email" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div>
                            <label for="companyPhone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <input type="text" id="companyPhone" v-model="form.company.phone"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div class="md:col-span-3">
                            <label for="companyAddress" class="block text-sm font-medium text-gray-700">Dirección</label>
                            <input type="text" id="companyAddress" v-model="form.company.address"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div class="hidden">
                        </div>
                    </div>

                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <h3 class="text-xl font-bold text-indigo-600 mb-5">
                            📍 Sucursal Principal
                        </h3>
                        <p class="text-sm text-gray-500 mb-5">
                            Esta será la primera sucursal de su empresa (Sede principal).
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label for="branchName" class="block text-sm font-medium text-gray-700">Nombre de la Sucursal *</label>
                                <input type="text" id="branchName" v-model="form.branch.name" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>

                            <div>
                                <label for="branchPhone" class="block text-sm font-medium text-gray-700">Teléfono *</label>
                                <input type="text" id="branchPhone" v-model="form.branch.phone" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>

                            <div>
                                <label for="branchEmail" class="block text-sm font-medium text-gray-700">Email *</label>
                                <input type="email" id="branchEmail" v-model="form.branch.email" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>

                            <div>
                                <label for="branchCity" class="block text-sm font-medium text-gray-700">Ciudad *</label>
                                <input type="text" id="branchCity" v-model="form.branch.city" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>

                            <div>
                                <label for="branchDepartment" class="block text-sm font-medium text-gray-700">Departamento *</label>
                                <input type="text" id="branchDepartment" v-model="form.branch.department" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>

                            <div>
                                <label for="branchImage" class="block text-sm font-medium text-gray-700">Imagen de la Sucursal (Opcional)</label>
                                <input type="file" id="branchImage" @change="handleFileUpload($event, 'branch', 'image')"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            </div>

                            <div class="md:col-span-2">
                                <label for="branchAddress" class="block text-sm font-medium text-gray-700">Dirección *</label>
                                <input type="text" id="branchAddress" v-model="form.branch.address" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>

                            <div class="space-y-4 pt-2 md:col-span-2">
                                <div class="flex items-center">
                                    <input id="branchIsActive" type="checkbox" v-model="form.branch.active"
                                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    <label for="branchIsActive" class="ml-2 block text-sm font-medium text-gray-700">Sucursal Activa</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>

                <section v-show="currentStep === 3" class="border border-gray-200 p-6 rounded-lg bg-indigo-50/50">
                    <h2 class="text-2xl font-bold text-indigo-600 mb-5 border-b pb-2">
                        ⚙️ Facturación y Opciones
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label for="taxRegime" class="block text-sm font-medium text-gray-700">Régimen Tributario</label>
                            <input type="text" id="taxRegime" v-model="form.company.tax_regime"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div>
                            <label for="economicActivityCode" class="block text-sm font-medium text-gray-700">Cód. Actividad Económica</label>
                            <input type="text" id="economicActivityCode" v-model="form.company.economic_activity_code"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div>
                            <label for="billingResolution" class="block text-sm font-medium text-gray-700">Resolución de Facturación</label>
                            <input type="text" id="billingResolution" v-model="form.company.billing_resolution"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div>
                            <label for="billingResolutionDate" class="block text-sm font-medium text-gray-700">Fecha de Resolución</label>
                            <input type="date" id="billingResolutionDate" v-model="form.company.billing_resolution_date"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div class="md:col-span-2">
                            <label for="companyLogo" class="block text-sm font-medium text-gray-700">Logo de la Empresa</label>
                            <input type="file" id="companyLogo"
                                @change="handleFileUpload($event, 'company', 'logo_path')"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                        </div>

                        <div class="space-y-4 pt-2 md:col-span-2">
                            <div class="flex items-center">
                                <input id="isActive" type="checkbox" v-model="form.company.active"
                                    class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="isActive" class="ml-2 block text-sm font-medium text-gray-700">Empresa Activa</label>
                            </div>
                        </div>

                        <div class="hidden">
                            <input type="text" v-model="form.company.city" />
                            <input type="text" v-model="form.company.department" />
                            <input type="text" v-model="form.company.country" />
                            <input type="text" v-model="form.company.is_verified" />
                            <input type="text" v-model="form.company.verified_at" />
                            <input type="text" v-model="form.company.color_theme" />
                            <input type="text" v-model="form.company.website" />
                            <input type="text" v-model="form.company.neighborhood" />
                        </div>
                    </div>
                </section>

                <div class="pt-6 flex justify-between">

                    <button type="button" @click="prevStep" v-if="currentStep > 1"
                            class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-150">
                        ← Anterior
                    </button>
                    <div v-else></div> <button type="button" @click="nextStep" v-if="currentStep < totalSteps"
                            :disabled="!isStepValid"
                            class="flex justify-center py-3 px-6 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 transition duration-150">
                        Siguiente →
                    </button>

                    <button type="submit" v-else-if="currentStep === totalSteps" :disabled="loading || !isStepValid"
                        class="flex justify-center py-3 px-6 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 transition duration-150">
                        <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>{{ loading ? 'Registrando...' : 'Finalizar Registro' }}</span>
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <router-link
                    :to="{ path: '/login' }"
                    class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600 transition duration-150"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver al inicio de sesión
                </router-link>
            </div>

            <div v-if="successMessage" class="mt-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ successMessage }}
            </div>
            <div v-if="errorMessage" class="mt-4 p-4 bg-red-100 text-red-700 rounded-lg">
                {{ errorMessage }}
            </div>

        </div>
    </div>
</template>

<script setup>
import { reactive, ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const totalSteps = 3;
const currentStep = ref(1);
const loading = ref(false);
const successMessage = ref(null);
const errorMessage = ref(null);
const validationError = ref(null); // Nuevo error para validación de frontend
const router = useRouter();

const API_BASE_URL = 'http://localhost:8000/api';

// ESTRUCTURA PRINCIPAL DEL FORMULARIO
const form = reactive({
    user: {
        name: '', email: '', password: '', phone: '', address: '', city: '', department: '',
        document_type: 'CC', document_number: '', avatar: null,
    },
    company: {
        name: '', legal_name: '', document_type: 'NIT', document_number: '', dv: '',
        email: '', phone: '', website: '', address: '', neighborhood: '', city: '',
        department: '', country: 'Colombia', tax_regime: '', economic_activity_code: '',
        billing_resolution: '', billing_resolution_date: '', is_verified: false,
        active: true, logo_path: null, color_theme: '#4f46e5', verified_at: null,
    },
    // ✅ NUEVO: Datos de la Sucursal
    branch: {
        name: '',
        phone: '',
        email: '',
        image: null, // string($binary)
        address: '',
        city: '',
        department: '',
        active: true, // boolean
    }
});

// --- Lógica de Navegación y Validación ---

const progressWidth = computed(() => {
    const progress = (currentStep.value / totalSteps) * 100;
    return `${progress}%`;
});

const isStepValid = computed(() => {
    validationError.value = null;

    if (currentStep.value === 1) {
        // Validación Paso 1: Datos del Administrador (mínimos)
        const user = form.user;
        if (!user.name || !user.email || !user.password || user.password.length < 6 || !user.document_number || !user.city || !user.department) {
            validationError.value = 'Complete los campos obligatorios del Administrador (Nombre, Email, Contraseña, Documento, Ciudad, Departamento).';
            return false;
        }
    }

    if (currentStep.value === 2) {
        // Validación Paso 2: Datos básicos de la Empresa y Sucursal
        const company = form.company;
        const branch = form.branch; // ✅ NUEVO: Obtener la sucursal

        if (!company.name || !company.email) {
            validationError.value = 'Complete los campos obligatorios de la Empresa (Nombre Comercial, Email).';
            return false;
        }

        // ✅ NUEVO: Validar campos obligatorios de la Sucursal
        if (!branch.name || !branch.phone || !branch.email || !branch.address || !branch.city || !branch.department) {
            validationError.value = 'Complete todos los campos obligatorios de la Sucursal Principal.';
            return false;
        }
    }

    // Paso 3 es la finalización, la validación final la hace el backend.
    return true;
});

const nextStep = () => {
    if (isStepValid.value) {
        currentStep.value++;
    }
};

const prevStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--;
    }
};

// --- Manejo de Archivos y Envío ---
const handleFileUpload = (event, type, field) => {
    const file = event.target.files[0];
    if (file) {
        if (type === 'user') {
            form.user[field] = file;
        } else if (type === 'company') {
            form.company[field] = file;
        } else if (type === 'branch') { // ✅ NUEVO: Manejo de archivo de sucursal
            form.branch[field] = file;
        }
    }
};

const handleSubmit = async () => {
    if (!isStepValid.value) return; // Doble chequeo

    loading.value = true;
    successMessage.value = null;
    errorMessage.value = null;

    const formData = new FormData();

    // Función auxiliar para agregar campos al FormData
    const appendData = (obj, parentKey) => {
        for (const key in obj) {
            if (Object.prototype.hasOwnProperty.call(obj, key)) {
                const value = obj[key];
                const formKey = parentKey ? `${parentKey}[${key}]` : key;

                if (value instanceof File) {
                    formData.append(formKey, value, value.name);
                } else if (typeof value === 'boolean') {
                    // Laravel espera 1 o 0 para booleanos
                    formData.append(formKey, value ? 1 : 0);
                } else if (value !== null && value !== undefined && value !== '') {
                    formData.append(formKey, value);
                }
            }
        }
    };

    // 1. Agregar datos del usuario (user[...])
    appendData(form.user, 'user');

    // 2. Agregar datos de la compañía (company[...])
    appendData(form.company, 'company');

    // ✅ 3. Agregar datos de la sucursal (branch[...])
    appendData(form.branch, 'branch');


    // 4. Enviar la petición a la API
    try {
        const response = await axios.post(`${API_BASE_URL}/registerCompany`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data' // Necesario para enviar archivos
            }
        });

        console.log('Respuesta del servidor:', response.data);

        successMessage.value = response.data.message || 'Registro completado con éxito.';

        // ✅ REDIRECCIÓN: Muestra el mensaje y redirige al login
        setTimeout(() => {
            router.push({ path: '/login' });
        }, 1500);

    } catch (error) {
        // Manejo de errores
        if (error.response) {
            if (error.response.status === 422 && error.response.data && error.response.data.errors) {
                const firstError = Object.values(error.response.data.errors)[0][0];
                errorMessage.value = `Error de validación: ${firstError}`;
            } else {
                errorMessage.value = error.response.data?.message || `Error ${error.response.status}: Intente de nuevo.`;
            }
        } else {
            errorMessage.value = 'No se pudo conectar al servidor. Verifique su conexión.';
        }
        // Opcional: Volver al Paso 1 si hay un error de validación grave
        currentStep.value = 1;

    } finally {
        loading.value = false;
    }
};
</script>


<style scoped>
/* Los estilos se mantienen igual */
</style>
