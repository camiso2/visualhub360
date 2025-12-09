<template>
    <div class="m-0 p-0 w-full upper-all">
        <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">


            <HeaderButtonGenInformComplet :title="`Cuentas por Cobrar `" :isDopDownVisible=true>
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8.25v-2.5m0 0c0-.69-.56-1.25-1.25-1.25H6.25A1.25 1.25 0 005 4.75v14.5c0 .69.56 1.25 1.25 1.25h4.5c.69 0 1.25-.56 1.25-1.25v-2.5m0-12.5h3.5c.69 0 1.25.56 1.25 1.25v3.5m-4.75 7.25h6.5c.69 0 1.25-.56 1.25-1.25V9.75L15.5 6H12m0 8.25H9.75m2.25 3H9.75" />
                    </svg>

                </template>
            </HeaderButtonGenInformComplet>

            <div class="flex w-full items-center space-x-2 mt-2">
                <input v-model="searchQuery" @keyup.enter="fetchReceivables(1)"
                    placeholder="Buscar ID / N° Factura / Documento cliente..." class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-blue-500 focus:border-blue-500
                                block w-full px-3 py-2 shadow-xs placeholder:text-body" />


                <button @click="fetchReceivables(1)" :disabled="isLoading" class="w-full gradient-button md:w-auto px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700
           disabled:bg-blue-300 transition flex items-center justify-center gap-2">

                    <span v-if="isLoading" class="flex items-center gap-2">
                        <svg v-if="!isLoading" class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span>Buscar</span>
                    </span>

                    <span v-else class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                            </path>
                        </svg>
                        <span>Buscando...</span>
                    </span>
                </button>
            </div>

            <div class="flex flex-col md:flex-row md:justify-between items-start md:items-center w-full mb-4 mt-4">
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-2 md:mt-0">
                    Total de Cuentas por Cobrar: <b>{{ pagination.total }}</b>
                </div>

                <div class="flex items-center space-x-2 mt-2 md:mt-0 mr-1">
                    <label for="perPageSelect" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Mostrar
                    </label>
                    <select id="perPageSelect" v-model="perPage" @change="fetchReceivables(1)"
                        class="border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option :value="10">10</option>
                        <option :value="25">25</option>
                        <option :value="50">50</option>
                    </select>
                    <span class="text-sm text-gray-500 dark:text-gray-400">filas</span>
                </div>
            </div>
        </div>









        <div v-if="loading" class="text-center p-4 text-blue-500">
            Cargando Cuentas por Cobrar...
        </div>

        <div v-else-if="!receivables.length"
            class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
            No se encontraron cuentas por cobrar pendientes.
        </div>

        <div v-else class="m-0 p-0 space-y-0 text-gray-600 dark:text-gray-300">

            <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">



                <div
                    class="bg-white mt-4 dark:bg-gray-900 h-[62rem] overflow-y-auto border border-gray-200 dark:border-gray-700 relative rounded-lg">

                    <div
                        class="hidden md:grid grid-cols-10 px-5 py-3 bg-gray-50 dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide border-b border-gray-100 dark:border-gray-700">

                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span>Factura</span>
                        </div>

                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Fec. Vencimiento</span>
                        </div>

                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Fec. registro</span>
                        </div>

                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 14c4.418 0 8 2.239 8 5v2H4v-2c0-2.761 3.582-5 8-5z" />
                            </svg>
                            <span>Cliente</span>
                        </div>

                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke-width="2"></circle>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h8m-4-4v8" />
                            </svg>
                            <span>Método Pago</span>
                        </div>

                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 8h6m-5 0a3 3 0 11-6 0 3 3 0 016 0zM12 8v4m-2 0h4m-4 0a3 3 0 100 6 3 3 0 000-6z" />
                            </svg>
                            <span>Monto Recibido</span>
                        </div>

                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 8h6m-5 0a3 3 0 11-6 0 3 3 0 016 0zM12 8v4m-2 0h4m-4 0a3 3 0 100 6 3 3 0 000-6z" />
                            </svg>
                            <span>Monto Total Venta</span>
                        </div>

                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Días Mora</span>
                        </div>

                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4" />
                            </svg>
                            <span>Estado</span>
                        </div>

                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Acciones</span>
                        </div>
                    </div>

                    <div v-for="receivable in receivables" :key="receivable.id" class="grid grid-cols-1 md:grid-cols-10 px-5 py-4 text-sm border-b border-gray-100 dark:border-gray-700
                        hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-150">


                        <div>
                            <span class="lg:hidden text-gray-400 text-xs font-semibold">Factura</span>

                            <a :href="'/storage/invoices/invoice-' + receivable.sale?.id + '.pdf'"
                                :download="'Factura-' + receivable.sale?.id + '.pdf'"
                                class="flex items-center gap-1 font-bold text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                <svg class="h-8 w-8" stroke-width="2" stroke="currentColor" fill="none"
                                    viewBox="0 0 24 24">
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                </svg>
                                <span>Descargar <span class="text-[11px] text-gray-400 block"><b>Factura N°:</b> {{
                                    receivable.sale?.invoice_number || 'N/A' }}</span></span>
                                <br>
                            </a>
                        </div>

                        <div>
                            <span class="lg:hidden text-gray-400 text-xs font-semibold">Fec. Vencimiento</span>
                            <span
                                :class="{ 'font-semibold text-red-600 dark:text-red-400': receivable.status === 'overdue' }"
                                class="text-gray-500 dark:text-gray-400 block">
                                {{
                                    receivable.due_date ?
                                        new Date(receivable.due_date).toLocaleDateString('es-CO', {
                                            year: 'numeric', month:
                                                '2-digit', day: '2-digit'
                                        })
                                        : 'Sin definir'
                                }}
                            </span>
                            <span class="text-[11px] text-gray-400 block">30 días despues de la venta </span>
                        </div>

                        <div>
                            <span class="lg:hidden text-gray-400 text-xs font-semibold">Fec. Registro</span>
                            <span
                                :class="{ 'font-semibold text-red-600 dark:text-red-400': receivable.status === 'overdue' }"
                                class="text-gray-500 dark:text-gray-400 block">
                                {{
                                    new Date(receivable.created_at).toLocaleDateString('es-CO', {
                                        year: 'numeric', month: '2-digit', day: '2-digit',
                                        hour: '2-digit', minute: '2-digit'
                                    })
                                }}
                            </span>
                        </div>

                        <div>
                            <span class="lg:hidden text-gray-400 text-xs font-semibold">Cliente </span>
                            <span class="font-semibold">{{ receivable.client?.name || 'sin datos' }}</span>
                            <span class="text-[11px] text-gray-400 block"><b>Contacto:</b> {{ receivable.client?.phone
                                ??
                                'sin_datos' }}</span>
                            <span class="text-[11px] text-gray-400 block">{{ receivable.client?.document_type ??
                                'sin_datos' }} : {{ receivable.client?.document_number ?? 'sin datos' }}</span>

                        </div>

                        <div>
                            <span class="lg:hidden text-gray-400 text-xs font-semibold">Método Pago </span>
                            <span><b>{{ receivable.payment_provider?.name || 'otro' }}</b></span>
                            <span class="text-[11px] text-gray-400 block">
                               Código : {{ receivable.payment_provider.code || 'N/A' }}
                            </span>
                        </div>
                        <div>
                            <span class="lg:hidden text-gray-400 text-xs font-semibold">Monto Recibido</span>
                            <span class="font-bold text-red-600 dark:text-red-400">
                                {{ formatCurrency(receivable.paid_amount) }}
                            </span>

                               <span class="text-[11px] text-gray-400 block">Monto Desc:
                               <b> {{ formatCurrency(receivable.sale?.grand_total - receivable.paid_amount) || 'Sin Pagar' }}</b>
                            </span>
                            <span class="text-[11px] text-gray-400 block"> Porc:
                                {{receivable.paid_amount === '0.00' || receivable.paid_amount === '0,00'  ? 'Sin Pagar' : (
                                    ((receivable.sale?.grand_total - receivable.paid_amount) / receivable.sale?.grand_total)
                                    * 100
                                ).toFixed(4) + ' %' || '0.0000 %' }}
                            </span>
                            <span class="text-[11px] text-gray-400 block">Fecha de Pago:
                                {{ receivable.paid_date || 'Sin Pagar' }}
                            </span>
                        </div>


                        <div>
                            <span class="lg:hidden text-gray-400 text-xs font-semibold">Monto Total Venta</span>
                            <span class="font-bold text-green-600 dark:text-red-400">
                                {{ formatCurrency(receivable.amount) }}
                            </span>
                            <span class="text-[11px] text-gray-400 block">Total Venta: {{
                                formatCurrency(receivable.sale?.grand_total || 0) }}</span>
                        </div>

                        <div>
                            <span class="lg:hidden text-gray-400 text-xs font-semibold">Días de Antigüedad </span>

                            <span class="font-semibold">
                                {{ calculateDaysElapsed(receivable.created_at) }} días
                            </span>

                            <span class="text-[11px] text-gray-400 block">
                                Fec. Reg:
                                {{ new Date(receivable.created_at).toLocaleDateString('es-CO', {
                                    hour: '2-digit', minute:
                                        '2-digit'
                                }) }}
                            </span>
                        </div>

                        <div>
                            <span class="lg:hidden text-gray-400 text-xs font-semibold">Estado </span>
                            <span :class="getStatusClass(receivable.status)"
                                class="px-3 py-1 text-xs font-semibold rounded-full capitalize">
                                {{ receivable.status === 'pending' ? 'Cuenta Pendiente' : 'Cuenta Pagada' }}
                            </span>
                        </div>


                        <div class="col-span-1 flex flex-col md:flex-row gap-2 mt-0">
                            <button v-if="receivable.status !== 'paid'" @click="openUpdateModal(receivable)" class="flex items-center justify-center space-x-2 bg-blue-500 hover:bg-blue-600 text-white
                            px-4 h-9 rounded-lg text-sm font-medium transition-all shadow-md
                            hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400
                            focus:ring-offset-1 w-full md:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m4 0h1a2 2 0 002-2v-6m-4 6H9m8 0a2 2 0 01-2 2H9a2 2 0 01-2-2h10z" />
                                </svg>

                                <span class="md:inline">Pagar</span>
                            </button>

                            <button @click="openModalForDetails(receivable)" class="flex items-center justify-center space-x-2 bg-green-500 hover:bg-green-600 text-white
                            px-4 h-9 rounded-lg text-sm font-medium transition-all shadow-md
                            hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-400
                            focus:ring-offset-1 w-full md:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064
                                    7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span class="md:inline">Detalle</span>
                            </button>
                        </div>
                    </div>
                    <div v-if="pagination.last_page > 1"
                        class="h-16 w-full flex flex-wrap gap-3 items-center justify-between px-4 text-sm font-medium border-t border-gray-200 bg-white shadow-inner">
                        <div class="text-gray-500">
                            Mostrando <b>{{ pagination.from }}</b> a <b>{{ pagination.to }}</b> de <b>{{
                                pagination.total }}</b> Cuentas
                        </div>

                        <div class="inline-flex rounded-md shadow-sm">
                            <button @click="fetchReceivables(pagination.current_page - 1)"
                                :disabled="!pagination.prev_page_url"
                                class="px-3 py-1.5 border border-gray-300 rounded-l-md bg-white hover:bg-gray-50 disabled:opacity-50">
                                Anterior
                            </button>

                            <button @click="fetchReceivables(pagination.current_page + 1)"
                                :disabled="!pagination.next_page_url"
                                class="px-3 py-1.5 border border-gray-300 rounded-r-md bg-white hover:bg-gray-50 disabled:opacity-50">
                                Siguiente
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <UpdateAccountPendingFormModal v-model="isUpdateModalOpen" :receivable-data="selectedReceivable"
            @dataUpdated="handleDataUpdated" :title="modalTitle" :statusPayment="statusPayment" />

    </div>
</template>


<script setup>
import { ref, onMounted, computed } from 'vue'
import api from '@/plugins/axios';
import HeaderButtonGenInformComplet from '../components/HeaderButtonGenInformComplet.vue'
import UpdateAccountPendingFormModal from '@/components/modals/UpdateAccountPendingFormModal.vue';
import SimpleLoader from '@/components/GlobalLoader.vue'; // Asegúrate de tener la ruta correcta

import { useAuthStore } from '@/stores/useAuthStore'
const isLoading = ref(true);
const authStore = useAuthStore()
const isDocumentModalOpen = ref(false);
const isUpdateModalOpen = ref(false);
const selectedReceivable = ref(null);
const page = ref(1);
const modalTitle = ref('');
const statusPayment = ref('');


const openUpdateModal = (receivableObject) => {
    selectedReceivable.value = receivableObject;
    // selectedClient.value = clientObject;
    isUpdateModalOpen.value = true;// Abre solo el modal de actualización
    console.log('Abriendo modal de Actualización para ID:', receivableObject);
    modalTitle.value = 'Cuenta por Cobrar (Pendiente)'; // Título para los Detalles
    statusPayment.value  = 'pendiente'
}
// Función que se ejecuta cuando el componente hijo termina de guardar el documento

const handleDataUpdated = () => {
    isUpdateModalOpen.value = false; //
    // selectedClient.value = clientObject;
    selectedReceivable.value = null;
    console.log('Pago realizado. Recargando lista...');
    // Cuando los datos cambian, recarga la lista para reflejar los cambios
    fetchReceivables();
    // También podrías considerar cerrar el modal si el modal hijo no lo hace:
    // isUpdateModalOpen.value = false;
}
const openModalForDetails = (receivableObject) => {
    selectedReceivable.value = receivableObject;
    modalTitle.value = 'Detalles de la Cuenta'; // 👈 Título del Modal
    statusPayment.value  = 'pagada'

    // Si necesitas un título específico para el botón, ¡asegúrate de definirlo!
    // buttonActionTitle.value = 'Guardar Detalles';

    isUpdateModalOpen.value = true;
};



// --- VARIABLES REACTIVAS ---
// Cambiado de 'sales' a 'receivables'
const receivables = ref([]);
const loading = ref(false);
const error = ref(null);
const searchQuery = ref('');
// perPage debe coincidir con el valor por defecto del backend (10) o el que desees mostrar.
const perPage = ref(10);
const pagination = ref({
    current_page: 1,
    last_page: 1,
    total: 0,
    from: 0,
    to: 0,
    prev_page_url: null,
    next_page_url: null,
});



const formatCurrency = (amount) => {
    // Usamos parseFloat o Number() para asegurar que la entrada es un número válido.
    return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(Number(amount));
};

// Función para determinar el estilo del estado de la cuenta por cobrar
const getStatusClass = (status) => {
    switch (status) {
        case 'paid': // Pagada
            return 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300';
        case 'pending': // Pendiente
            return 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300';
        case 'overdue': // Vencida
            return 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300';
        default:
            return 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300';
    }
};

const shouldShowPage = (page) => {
    const currentPage = pagination.value.current_page;
    const lastPage = pagination.value.last_page;
    if (page === 1 || page === lastPage || (page >= currentPage - 2 && page <= currentPage + 2)) {
        return true;
    }
    return false;
};

// --- FUNCIÓN PRINCIPAL DE CONSULTA A LA API ---
const fetchReceivables = async (page = 1) => {
    loading.value = true;
    error.value = null;


    try {
        // Endpoint cambiado a /accountsReceivable
        const response = await api.get(`/accountsReceivable`, {
            params: {
                page: page,
                search: searchQuery.value,
                per_page: perPage.value,
                // Aquí podrías agregar un filtro por status: status: 'pending',
            }
        });

        // 1. Extraer los datos (la data de la lista está en data.receivables.data)
        const data = response?.data?.data;

        // Asignar datos de las cuentas por cobrar
        receivables.value = data?.receivables?.data || [];


        // 2. Asignar la información de paginación
        if (data && data.receivables) {
            pagination.value = {
                current_page: data.receivables.current_page,
                last_page: data.receivables.last_page,
                total: data.receivables.total,
                from: data.receivables.from,
                to: data.receivables.to,
                prev_page_url: data.receivables.prev_page_url,
                next_page_url: data.receivables.next_page_url,
            };
        } else {
            pagination.value = { current_page: 1, last_page: 1, total: 0, from: 0, to: 0 };
        }

        console.log("Cuentas por cobrar obtenidas:", receivables.value);

        // Notificación de éxito
        // Nota: Si esto se llama muy a menudo (al buscar o cambiar de página), puede ser molesto.
        // Swal.fire({
        //     position: "top-end",
        //     icon: "success",
        //     title: "Cuentas por cobrar obtenidas con éxito!",
        //     showConfirmButton: false,
        //     timer: 1500
        // });

    } catch (err) {
        error.value = err.response?.data?.message || err.message || 'Error desconocido al obtener las cuentas por cobrar.';
        console.error("Error al obtener cuentas por cobrar:", err);
        // Notificación de error
        Swal.fire({
            icon: "error",
            title: "¡Error!",
            text: error.value,
        });
    } finally {
        loading.value = false;
    }
};

// --- OTRAS FUNCIONES DE ACCIÓN ---
const viewDetails = (id) => {
    console.log('Ver detalles de la cuenta por cobrar:', id);
    // Lógica de navegación o modal
};

const recordPayment = (id) => {
    console.log('Registrar pago para la cuenta por cobrar:', id);
    // Lógica para abrir modal de registro de pago
};


// --- EJECUCIÓN INICIAL ---
// Cargar cuentas por cobrar al montar el componente
onMounted(() => {
    fetchReceivables();
});

// Función para manejar el cambio de página
const goToPage = (page) => {
    if (page >= 1 && page <= pagination.value.last_page) {
        fetchReceivables(page);
    }
};

// Asegúrate de que esta función está definida en tu <script setup>
const calculateDaysElapsed = (registrationDate) => {
    // 1. La entrada debe ser el string ISO 8601 del backend (ej: "2025-11-25T20:03:00.000000Z")
    const start = new Date(registrationDate);

    // 2. Fecha actual
    const end = new Date();

    if (isNaN(start)) {
        return 0;
    }

    // 3. Opcional, pero recomendado: Asegurar que la fecha de inicio no es posterior a la actual
    if (start.getTime() > end.getTime()) {
        return 0;
    }

    // Convertir las fechas a medianoche del día, lo que estabiliza el cálculo de días completos.
    start.setHours(0, 0, 0, 0);
    end.setHours(0, 0, 0, 0);

    // 4. Calcular la diferencia en milisegundos y luego en días.
    const diffTime = end.getTime() - start.getTime(); // Notar que ya no necesitamos Math.abs() si validamos.

    // Convertir a días y redondear (ceil)
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    return diffDays;
};

</script>
