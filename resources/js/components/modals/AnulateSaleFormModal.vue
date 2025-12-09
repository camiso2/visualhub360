<template>
    <DocumentsRoot :modelValue="props.modelValue" @update:modelValue="value => emit('update:modelValue', value)"
        title=" " :sale-id="props.saleId">

        <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700 ">

            <HeaderButtonGenInformComplet :title="props.title" :isDopDownVisible="false">
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

                <div :class="{
                    // Color de fondo basado en el estado (más profesional que solo verde)
                    'border-green-300 dark:border-green-700': saleData.status !== 'pending',
                    'border-yellow-400 dark:border-yellow-600': saleData.status === 'pending'
                }" class="p-4 rounded-lg shadow-md border-l-4 bg-white dark:bg-gray-800 transition duration-150">

                    <div
                        class="flex flex-col sm:flex-row justify-between items-start mb-4 border-b pb-3 border-gray-200 dark:border-gray-700">

                        <div class="flex flex-col w-full sm:w-auto text-center sm:text-left mb-2 sm:mb-0">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                Factura N° {{ saleData.invoice_number }}
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Registrada el:
                                {{ new Date(saleData.created_at).toLocaleDateString('es-CO', {
                                    hour: '2-digit', minute:
                                        '2-digit'
                                }) }}
                            </p>
                        </div>


                       <div class="text-center sm:text-right w-full sm:w-auto">
                            <p class="text-2xl font-extrabold text-green-600 dark:text-green-400">
                               {{ formatCurrency(saleData.total_amount) }}
                            </p>

                            <span :class="saleData.status === 'cenceled'
                                ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300'
                                : 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'"
                                class="px-3 py-1 text-xs font-semibold rounded-full mt-1 inline-block">
                                {{ saleData.status === 'completed' ? 'Completada' : 'Anulada' }}
                            </span>
                        </div>
                    </div>

                    <h4 class="text-sm font-semibold mb-2 text-indigo-600 dark:text-indigo-400">
                        Datos de la Venta
                    </h4>
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm text-gray-700 dark:text-gray-300">

                        <div>
                            <span class="font-medium text-gray-500 dark:text-gray-400 block">Método de Pago:</span>
                            <span>{{ saleData.payment_method }}</span>
                        </div>

                        <div>
                            <span class="font-medium text-gray-500 dark:text-gray-400 block">N° Transacción:</span>
                            <span>{{ saleData.number_transactions || 'N/A' }}</span>
                        </div>

                        <div>
                            <span class="font-medium text-gray-500 dark:text-gray-400 block">Descuento Total:</span>
                            <span>{{ formatCurrency(saleData.discount_amount) }}</span>
                        </div>

                        <div class="col-span-1 sm:col-span-2">
                            <span class="font-medium text-gray-500 dark:text-gray-400 block">Cliente:</span>
                            <span>
                                {{ saleData.client.name }} <br>
                                <span class="text-gray-500 dark:text-gray-400">{{saleData.client.document_type}} : {{ saleData.client.document_number}}</span> <br>
                                <span class="text-gray-500 dark:text-gray-400">{{ saleData.client.phone}}</span>
                            </span>
                        </div>
                    </div>
                </div>
                <hr class="mt-3 mb-3" />
                <form v-if="statusPayment == 'completed'" @submit.prevent="handleSubmit" class="flex flex-wrap items-start gap-6">
                    <input type="hidden" v-model="form.id">
                </form>
            </div>
        </div>

        <template #footer>
            <div class="flex flex-col md:flex-row gap-4 mt-4">
                <button @click="emit('update:modelValue', false)" type="button" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100
        dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700
        w-full md:w-auto">
                    Cerrar
                </button>
                <div v-if="statusPayment == 'completed'">
                <button  @click="handleSubmit" :disabled="loading" class="flex items-center justify-center
        py-2 px-6 border border-transparent
        rounded-lg shadow-md text-lg font-medium text-white
        bg-red-600 hover:bg-red-700 focus:outline-none
        focus:ring-2 focus:ring-offset-2 focus:ring-red-500
        disabled:opacity-50 transition duration-150
        w-full md:w-auto text-center ">

                    <svg v-if="loading" class="animate-spin mr-3 h-5 w-5 text-white" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2.01 5.938A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m4 0h1a2 2 0 002-2v-6m-4 6H9m8 0a2 2 0 01-2 2H9a2 2 0 01-2-2h10z" />
                                </svg>

                    <span class="leading-snug whitespace-nowrap text-center">
                        {{ loading ? 'Anulando Venta...' : 'Anular Venta' }}
                    </span>
                </button>
                </div>
            </div>
        </template>
    </DocumentsRoot>
</template>

<script setup>
import { reactive, ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import HeaderButtonGenInformComplet from '@/components/HeaderButtonGenInformComplet.vue';
// import DepartamentoCiudadSelect from '@/components/DepartamentoCiudadSelect.vue'; // Ya no se necesita si eliminamos address/city
import api from "@/plugins/axios";
import DocumentsRoot from './DocumentsRoot.vue'
import { useAuthStore } from '@/stores/useAuthStore'

// ----------------------------------------------------------------------
// 1. PINIA & ESTADO GLOBAL
// ----------------------------------------------------------------------
const authStore = useAuthStore();

// ----------------------------------------------------------------------
// 2. PROPS y EMITS
// ----------------------------------------------------------------------
const props = defineProps({
    modelValue: Boolean,
    saleData: {
        type: Object,
        default: null
    },
    title: {
        type: String,
        default: 'Cuenta por Cobrar' // Título por defecto
    }, statusPayment: {
        type: String,
        default: 'pagada' // Título por defecto
    },

})

const emit = defineEmits(['update:modelValue', 'documentSaved', "sale-registered", "dataUpdated"])
const router = useRouter();


// ----------------------------------------------------------------------
// 3. ESTADO LOCAL
// ----------------------------------------------------------------------
const loading = ref(false);
const successMessage = ref(null);
const errorMessage = ref(null);


// ----------------------------------------------------------------------
// 4. FORMULARIO REACTIVO (SIMPLIFICADO) 🎯
// ----------------------------------------------------------------------
const form = reactive({
    id: null,
    amount: null,
    paid_amount: null, // Campo para el monto recibido
    // Los demás campos (name, email, etc.) han sido eliminados.
});


// ----------------------------------------------------------------------
// 5. LÓGICA DE CARGA DE DATOS (WATCHER SIMPLIFICADO) 🎯
// ----------------------------------------------------------------------
watch(() => props.saleData, (newsaleData) => {


    // Si newsaleData es null o undefined, limpia el formulario
    if (!newsaleData) {
        form.id = null;
        form.paid_amount = null;
        // console.log('Formulario limpiado para un nuevo registro.');
        return;
    }



    // Mapear solo los datos necesarios (ID y Monto)
    form.id = newsaleData.id;
    // Inicializar el monto del formulario con el monto actual de la cuenta por cobrar
    // Esto es opcional, si quieres que el usuario vea el valor actual.
    form.paid_amount = newsaleData.amount;

    // console.log('Formulario precargado para el salee ID:', form.id);
}, { immediate: true });


// ----------------------------------------------------------------------
// 6. MANEJADORES DE EVENTOS Y SUBMIT (El bucle de envío se ajusta automáticamente)
// ----------------------------------------------------------------------

// NOTA: handleFileUpload ya no tiene sentido si eliminamos form.avatar. Lo dejo comentado.
// const handleFileUpload = (event) => { /* ... */ };

const handleSubmit = async () => {
    authStore.loading = true;
    loading.value = true;
    errorMessage.value = null;
    successMessage.value = null;
    const token = authStore.token;

    if (!token) {
        errorMessage.value = 'No se encontró el token de autenticación.';
        loading.value = false;
        return;
    }

    const formData = new FormData();

    if (form.id) {
        formData.append('id', form.id);
    }

    try {
        const response = await api.post(`/admin/sales/${form.id}/cancel`, formData);
        // La variable 'isUpdate' no existe, simplificamos el mensaje
        successMessage.value = response.data.message ?? 'Venta Cancelada Éxitosamente.';

        Swal.fire({
            position: "top-end",
            icon: "success",
            title: 'Venta Cancelada Éxitosamente.',
            showConfirmButton: false,
            timer: 1500
        });

        emit("dataUpdated", {
            success: true,
            saleId: form.id,
            data: response.data.sale
        });
        emit("sale-registered", {
            success: true,
            // document_number: form.document_number // Eliminado, ya no existe en form
        });

        emit('update:modelValue', false);
        authStore.loading = false;
    } catch (error) {
        console.log(error)
        // ... (lógica de manejo de errores original)
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
        loading.value = false;
        authStore.loading = false;
    }
};

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(Number(amount));
};

const formatCurrencyAnglo = (amount) => {
    // 1. Convertir el monto a un número (asegura que funcione)
    const numberAmount = Number(amount);

    // 2. Usar un formato que entregue el punto como decimal (ej. 'en-US' o 'es-ES')
    // y evita el símbolo de moneda 'style: "decimal"'
    const formatted = new Intl.NumberFormat('en-US', {
        style: 'decimal',
        minimumFractionDigits: 2, // Asegura dos decimales
        maximumFractionDigits: 2
    }).format(numberAmount);

    // 3. Opcional: Eliminar el separador de miles (la coma en 'en-US')
    // si el valor es muy grande (ej. 1,345,200.23) y quieres el resultado exacto 345200.23.
    // En tu ejemplo (345.200,23 -> 345,200.23), la coma (separador de miles) ya se genera.
    // Si realmente quieres eliminar el separador de miles, puedes hacer esto:

    // El formato 'en-US' con style: 'decimal' te dará "345,200.23"
    // Para obtener "345200.23" eliminamos la coma:
    return formatted.replace(/,/g, '');
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
