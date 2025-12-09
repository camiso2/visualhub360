<template>
    <div class="m-0 p-0 w-full upper-all">
        <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">

            <HeaderButtonGenInformComplet :title="`Lista de Ventas`" :isDopDownVisible = true>
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8.25v-2.5m0 0c0-.69-.56-1.25-1.25-1.25H6.25A1.25 1.25 0 005 4.75v14.5c0 .69.56 1.25 1.25 1.25h4.5c.69 0 1.25-.56 1.25-1.25v-2.5m0-12.5h3.5c.69 0 1.25.56 1.25 1.25v3.5m-4.75 7.25h6.5c.69 0 1.25-.56 1.25-1.25V9.75L15.5 6H12m0 8.25H9.75m2.25 3H9.75" />
                    </svg>

                </template>
            </HeaderButtonGenInformComplet>

            <!-- BUSCADOR -->
            <div class="flex w-full items-center space-x-2 mt-2">
                <input v-model="searchQuery" @keyup.enter="fetchSales(1)"
                    placeholder="Buscar N° Factura / Transacción / Ducumento cliente..." class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-blue-500 focus:border-blue-500
                               block w-full px-3 py-2 shadow-xs placeholder:text-body" />


                 <button @click="fetchSales(1)" :disabled="isLoading" class="w-full gradient-button md:w-auto px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700
           disabled:bg-blue-300 transition flex items-center justify-center gap-2">

                    <span v-if="isLoading" class="flex items-center gap-2">
                        <svg v-if="!isLoading" class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span>Buscando...</span>
                    </span>

                    <span v-else class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                            </path>
                        </svg>
                        <span>Buscar</span>
                    </span>
                </button>

            </div>

            <div class="flex flex-col md:flex-row md:justify-between items-start md:items-center w-full mb-4 mt-4">
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-2 md:mt-0">
                    Total de ventas: <b>{{ pagination.total }}</b>
                </div>

                <div class="flex items-center space-x-2 mt-2 md:mt-0 mr-1">
                    <label for="perPageSelect" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Mostrar
                    </label>
                    <select id="perPageSelect" v-model="perPage" @change="fetchSales(1)"
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
            Cargando ventas...
        </div>

        <div v-else-if="!sales.length"
            class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
            No se encontraron ventas.
        </div>

        <div v-else class="m-0 p-0 space-y-0 text-gray-600 dark:text-gray-300">

            <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">



                <!-- CONTENEDOR SCROLL -->
                <div
                    class="bg-white mt-4 dark:bg-gray-900 h-[62rem] overflow-y-auto border border-gray-200 dark:border-gray-700 relative rounded-lg">

                    <!-- ENCABEZADO (SOLO DESKTOP) -->
                    <div
                        class="hidden md:grid grid-cols-10 px-5 py-3 bg-gray-50 dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide border-b border-gray-100 dark:border-gray-700">

                        <div class="flex items-center space-x-2 w-30">
                            <!-- FACTURA -->
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 21h4c1.657 0 3-1.343 3-3V7a3 3 0 00-3-3h-4a3 3 0 00-3 3v11c0 1.657 1.343 3 3 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 10h4M10 14h4" />
                            </svg>
                            <span>Factura</span>
                        </div>

                        <div class="flex items-center space-x-2 w-30">
                            <!-- FECHA -->
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11h.01" />
                            </svg>
                            <span>Fec. Registro</span>
                        </div>

                        <div class="flex items-center space-x-2 w-30">
                            <!-- CLIENTE -->
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 14c4.418 0 8 2.239 8 5v2H4v-2c0-2.761 3.582-5 8-5z" />
                            </svg>
                            <span>Cliente</span>
                        </div>

                        <div class="flex items-center space-x-2 w-30">
                            <!-- VENDEDOR -->
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Vendedor</span>
                        </div>

                        <div class="flex items-center space-x-2 w-30">
                            <!-- N° FACTURA -->
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="14" r="6" stroke-width="2"></circle>
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 11V3" />
                            </svg>
                            <span>N° Factura</span>
                        </div>

                        <div class="flex items-center space-x-2 w-30">
                            <!-- N° TRANSACCIÓN -->
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <span>N° Transacción</span>
                        </div>

                        <div class="flex items-center space-x-2 w-30">
                            <!-- MÉTODO PAGO -->
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="3" y="7" width="18" height="10" rx="2" stroke-width="2"></rect>
                                <line x1="7" y1="12" x2="17" y2="12" stroke-width="2"></line>
                            </svg>
                            <span>Método Pago</span>
                        </div>

                        <div class="flex items-center space-x-2 w-30">
                            <!-- TOTAL -->
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8c-3.3 0-6 2.7-6 6s2.7 6 6 6 6-2.7 6-6-2.7-6-6-6z" />
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 5V3" />
                            </svg>
                            <span>Total</span>
                        </div>

                        <div class="flex items-center space-x-2 w-30">
                            <!-- ESTADO -->
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4" />
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M5 21h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                            </svg>
                            <span>Estado</span>
                        </div>

                        <div class="flex items-center space-x-2 w-30">
                            <!-- ACCIONES -->
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Acciones</span>
                        </div>
                    </div>

                    <!-- FILAS -->
                    <div v-for="sale in sales" :key="sale.id" class="grid grid-cols-1 md:grid-cols-10 px-5 py-4 text-sm border-b border-gray-100 dark:border-gray-700
                        hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-150">

                        <!-- FACTURA -->
                        <div>
                            <span class="lg:hidden text-gray-400 text-xs font-semibold">Factura</span>

                            <p></p>

                            <a :href="'/storage/invoices/invoice-' + sale.id + '.pdf'"
                                :download="'Factura-' + sale.id + '.pdf'"
                                class="flex items-center gap-1 font-bold text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                <svg class="h-8 w-8" stroke-width="2" stroke="currentColor" fill="none"
                                    viewBox="0 0 24 24">
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                </svg>
                                <span>Descargar <span class="text-[11px] text-gray-400 block"><b>Factura N°:</b> {{
                                    sale.invoice_number || 'N/A' }}</span></span>
                                <br>
                            </a>
                        </div>



                        <!-- FECHA -->
                        <div>
                            <span class="lg:hidden text-gray-400 text-xs font-semibold">Fecha </span>
                            <span class="text-gray-500 dark:text-gray-400 block">
                                {{
                                    new Date(sale.created_at).toLocaleDateString('es-CO', {
                                        year: 'numeric', month: '2-digit', day: '2-digit',
                                        hour: '2-digit', minute: '2-digit'
                                    })
                                }}
                            </span>
                        </div>

                        <!-- CLIENTE -->
                        <div>
                            <span class="lg:hidden text-gray-400 text-xs font-semibold">Cliente </span>
                            <span class="font-semibold">{{ sale.client?.name || 'sin datos' }}</span>
                            <span class="text-[11px] text-gray-400 block">Contacto: {{ sale.client?.phone ??
                                'sin_datos'}}</span>
                            <span class="text-[11px] text-gray-400 block">{{ sale.client?.document_type ?? 'sin_datos'
                            }}
                                {{ sale.client?.document_number ?? 'sin datos' }}</span>
                        </div>

                        <!-- VENDEDOR -->
                        <div>
                            <span class="lg:hidden text-gray-400 text-xs font-semibold">Vendedor </span>
                            <span class="font-semibold">{{ sale.user?.name || 'sin datos' }}</span>
                            <span class="text-[11px] text-gray-400 block">Contacto: {{ sale.user?.phone ?? 'sin datos'
                                }}</span>
                        </div>

                        <!-- N° FACTURA -->
                        <div>
                            <span class="lg:hidden text-gray-400 text-xs font-semibold">N° Factura </span>
                            <span class="font-semibold ">N° {{ sale.invoice_number }}</span>
                        </div>

                        <!-- N° TRANSACCIÓN -->
                        <div class="w-30">
                            <span class="lg:hidden text-gray-300 text-xs font-semibold">N° Transacción </span>
                            <span class="font-semibold text-gray-600">{{ sale.number_transactions }}</span>
                        </div>

                        <!-- MÉTODO PAGO -->
                        <div>
                            <span class="lg:hidden text-gray-400 text-xs font-semibold">Método Pago </span>
                            <span>{{ sale.payment_method }}</span>
                        </div>

                        <!-- TOTAL -->
                        <div>
                            <span class="lg:hidden text-gray-400 text-xs font-semibold">Total </span>
                            <span class="font-bold text-green-600 dark:text-green-400">{{
                                formatCurrency(sale.grand_total) }}</span>
                        </div>

                        <!-- ESTADO -->
                        <div>
                            <span class="lg:hidden text-gray-400 text-xs font-semibold">Estado </span>
                            <span :class="getStatusClass(sale.status)"
                                class="px-3 py-1 text-xs font-semibold rounded-full">
                                {{ sale.status === 'completed' ? 'Completada' : sale.status === 'canceled' ? 'Anulada' : sale.status}}
                            </span>
                        </div>


                        <!-- ACCIONES RESPONSIVE -->
                        <div class="col-span-1 flex flex-col md:flex-row gap-2 mt-0">
                            <button v-if="sale.status !== 'canceled'" @click="openUpdateModal(sale)" class="flex items-center justify-center space-x-2 bg-red-500 hover:bg-red-600 text-white
                            px-4 h-9 rounded-lg text-sm font-medium transition-all shadow-md
                            hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400
                            focus:ring-offset-1 w-full md:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m4 0h1a2 2 0 002-2v-6m-4 6H9m8 0a2 2 0 01-2 2H9a2 2 0 01-2-2h10z" />
                                </svg>

                                <span class="md:inline">Anular </span>
                            </button>

                            <button @click="openModalForDetails(sale)" class="flex items-center justify-center space-x-2 bg-green-500 hover:bg-green-600 text-white
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
                    <!-- PAGINACIÓN -->
                    <div v-if="pagination.last_page > 1"
                        class="h-16 w-full flex flex-wrap gap-3 items-center justify-between px-4 text-sm font-medium border-t border-gray-200 bg-white shadow-inner">
                        <div class="text-gray-500">
                            Mostrando <b>{{ pagination.from }}</b> a <b>{{ pagination.to }}</b> de <b>{{
                                pagination.total }}</b> Ventas
                        </div>

                        <div class="inline-flex rounded-md shadow-sm">
                            <button @click="fetchSales(pagination.current_page - 1)"
                                :disabled="!pagination.prev_page_url"
                                class="px-3 py-1.5 border border-gray-300 rounded-l-md bg-white hover:bg-gray-50 disabled:opacity-50">
                                Anterior
                            </button>



                            <button @click="fetchSales(pagination.current_page + 1)"
                                :disabled="!pagination.next_page_url"
                                class="px-3 py-1.5 border border-gray-300 rounded-r-md bg-white hover:bg-gray-50 disabled:opacity-50">
                                Siguiente
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
          <AnulateSaleFormModal v-model="isUpdateModalOpen" :sale-data="selectedsale"
            @dataUpdated="handleDataUpdated" :title="modalTitle" :statusPayment="statusPayment" />
    </div>
</template>


<script setup>
import { ref, onMounted, onBeforeUnmount, computed } from 'vue' // Se agrega 'computed'
import api from '@/plugins/axios';
import HeaderButtonGenInformComplet from '../components/HeaderButtonGenInformComplet.vue'
import AnulateSaleFormModal from '@/components/modals/AnulateSaleFormModal.vue';

import { useAuthStore } from '@/stores/useAuthStore'

const authStore = useAuthStore()
const isDocumentModalOpen = ref(false);
const isUpdateModalOpen = ref(false);
const selectedsale = ref(null);

const modalTitle = ref('');
const statusPayment = ref('');


const openUpdateModal = (saleObject) => {
    selectedsale.value = saleObject;
    // selectedClient.value = clientObject;
    isUpdateModalOpen.value = true;// Abre solo el modal de actualización
    console.log('Abriendo modal de Actualización para ID:', saleObject);
    modalTitle.value = 'Venta por Anular'; // Título para los Detalles
    statusPayment.value  = 'completed'
}
// Función que se ejecuta cuando el componente hijo termina de guardar el documento

const handleDataUpdated = () => {
    isUpdateModalOpen.value = false; //
    // selectedClient.value = clientObject;
    selectedsale.value = null;
    console.log('Pago realizado. Recargando lista...');
    // Cuando los datos cambian, recarga la lista para reflejar los cambios
    fetchSales();
    // También podrías considerar cerrar el modal si el modal hijo no lo hace:
    // isUpdateModalOpen.value = false;
}
const openModalForDetails = (saleObject) => {
    selectedsale.value = saleObject;
    modalTitle.value = 'Detalles de la Venta'; // 👈 Título del Modal
    statusPayment.value  = 'canceled'

    // Si necesitas un título específico para el botón, ¡asegúrate de definirlo!
    // buttonActionTitle.value = 'Guardar Detalles';

    isUpdateModalOpen.value = true;
};



// Inicialización de Stores

const isLoading = ref(false);
const page = ref(1);
// --- VARIABLES REACTIVAS ---
const sales = ref([]);
const loading = ref(false);
const error = ref(null); // Variable para manejar errores
const searchQuery = ref('');
const perPage = ref(8);
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
    return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(amount);
};

const getStatusClass = (status) => {
    switch (status) {
        case 'completed':
            return 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300';
        case 'canceled':
            return 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300';
        default:
            return 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300';
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
const fetchSales = async (page = 1) => {
    loading.value = true;
    error.value = null; // Limpiar errores previos

    try {
        // Construcción de la URL de la API con parámetros de paginación y búsqueda
        const response = await api.get(`/sales`, {
            params: {
                page: page,
                search: searchQuery.value,
                per_page: perPage.value,
                // Puedes agregar más parámetros como filtros de fecha aquí si los tienes
            }
        });

        // 1. Extraer los datos de las ventas y la información de paginación
        const data = response?.data?.data;

        // Asignar datos de las ventas (asumiendo que vienen en data.sales.data)
        sales.value = data?.sales?.data || [];


        // 2. Asignar la información de paginación
        if (data && data.sales) {
            pagination.value = {
                current_page: data.sales.current_page,
                last_page: data.sales.last_page,
                total: data.sales.total,
                from: data.sales.from,
                to: data.sales.to,
                prev_page_url: data.sales.prev_page_url,
                next_page_url: data.sales.next_page_url,
            };
        } else {
            // Si la estructura no es la esperada, restablecer la paginación a valores seguros
            pagination.value = { current_page: 1, last_page: 1, total: 0, from: 0, to: 0 };
        }

        console.log("Ventas obtenidas:", sales.value);

        // Notificación de éxito
        /*.fire({
            position: "top-end",
            icon: "success",
            title: "Ventas obtenidas con éxito!",
            showConfirmButton: false,
            timer: 1500
        });*/

    } catch (err) {
        error.value = err.response?.data?.message || err.message || 'Error desconocido al obtener las ventas.';
        console.error("Error al obtener ventas:", err);
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
    console.log('Ver detalles de la venta:', id);
    // Lógica de navegación o modal
};

const cancelSale = (id) => {
    console.log('Anular venta:', id);
    // Lógica de anulación de API
    // Podrías usar un Swal.fire con confirmación antes de la llamada a la API
};

// --- EJECUCIÓN INICIAL ---
// Cargar ventas al montar el componente
onMounted(() => {
    fetchSales();
});

// Función para manejar el cambio de página
const goToPage = (page) => {
    if (page >= 1 && page <= pagination.value.last_page) {
        fetchSales(page);
    }
};

</script>
