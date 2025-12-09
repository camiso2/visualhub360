<template>
    <div class="m-0 p-0 w-full ">


        <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">



            <HeaderButtonGenInformComplet :title="`Inventario actual`" :isDopDownVisible=true>
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8.25v-2.5m0 0c0-.69-.56-1.25-1.25-1.25H6.25A1.25 1.25 0 005 4.75v14.5c0 .69.56 1.25 1.25 1.25h4.5c.69 0 1.25-.56 1.25-1.25v-2.5m0-12.5h3.5c.69 0 1.25.56 1.25 1.25v3.5m-4.75 7.25h6.5c.69 0 1.25-.56 1.25-1.25V9.75L15.5 6H12m0 8.25H9.75m2.25 3H9.75" />
                    </svg>

                </template>
            </HeaderButtonGenInformComplet>

            <div class="flex w-full items-center space-x-2 mt-2">
                <input v-model="searchQuery" @keyup.enter="fetchInventories(1)" placeholder="Buscar producto..." class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-blue-500 focus:border-blue-500
                                block w-full px-3 py-2 shadow-xs placeholder:text-body" />


                <button @click="fetchInventories(1)" :disabled="loading" class="w-full gradient-button md:w-auto px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700
           disabled:bg-blue-300 transition flex items-center justify-center gap-2">

                    <span v-if="loading" class="flex items-center gap-2">
                        <svg v-if="!loading" class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
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
                    Total de Productos: <b>{{ pagination.total }}</b>
                </div>

                <div class="flex items-center space-x-2 mt-2 md:mt-0 mr-1">
                    <label for="perPageSelect" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Mostrar
                    </label>
                    <select id="perPageSelect" v-model="perPage" @change="fetchInventories(1)"
                        class="border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option :value="1">1</option>
                        <option :value="3">3</option>
                        <option :value="5">5</option>
                        <option :value="10">10</option>
                        <option :value="15">15</option>
                        <option :value="20">20</option>
                    </select>
                    <span class="text-sm text-gray-500 dark:text-gray-400"> Productos</span>
                </div>

            </div>
        </div>

        <div v-if="loading" class="text-center p-4 text-indigo-500">
            Cargando inventario...
        </div>

        <div v-else-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
            role="alert">
            Error al cargar el inventario: {{ error }}
        </div>

        <div v-else-if="inventories.length === 0 && searchQuery === ''"
            class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
            No se encontraron productos en esta sucursal.
        </div>

        <div v-else class="m-0 p-0 space-y-4 text-gray-600 dark:text-gray-300">
            <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">


                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 p-2 min-h-[500px]">

                    <div v-for="inventory in inventories" :key="inventory.id" :class="{
                        // CLASES POR DEFECTO (siempre aplicadas)
                        'rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border flex flex-col': true, 'bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700': inventory.active === 1, 'bg-gray-50 dark:bg-gray-950 border-gray-300 dark:border-gray-800 opacity-60': inventory.active !== 1
                    }">
                        <!-- <span :class="inventory.active === 1
                            ? 'bg-green-600 text-white'
                            : 'bg-indigo-100 text-white-700 dark:bg-indigo-900 dark:text-white-300'"
                            class="absolute top-3 right-3 px-3 py-1 text-xs font-semibold rounded-full z-10">
                            {{ inventory.active === 1 ? 'Activo' : 'Inactivo' }}
                        </span>>-->

                        <div class="relative h-48 overflow-hidden rounded-t-xl">
                            <img :src="inventory.image || '/inventories/default.png'" alt="Imagen de Producto"
                                class="w-full h-full object-cover"
                                onerror="this.onerror=null;this.src='/inventories/default.png'">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-gray-900/70 via-gray-900/20 to-transparent">
                            </div>
                            <h3 class="absolute bottom-3 left-3 text-white text-lg font-bold z-10">
                                {{ inventory.name }}
                            </h3>



                            <span :class="inventory.active === 1
                                ? 'bg-green-600 text-white'
                                : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300'"
                                class="absolute top-3 right-3 px-3 py-1 text-xs font-semibold rounded-full z-10">
                                {{ inventory.active === 1 ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>

                        <div class="p-4 flex-grow dark:text-gray-300">
                            <div class="flex justify-between items-center text-sm font-medium mb-3 border-b pb-2">
                                <span class="text-gray-500 dark:text-gray-400">Código de Barras:</span>
                                <span>{{ inventory.sku }}</span>
                            </div>

                            <div class="flex justify-between items-center text-sm mb-3">
                                <span class="text-gray-500 dark:text-gray-400">Categoría:</span>
                                <span>{{ inventory.category }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm mb-3">
                                <span class="text-gray-500 dark:text-gray-400">Creado por:</span>
                                <span class="font-medium text-indigo-500">{{ inventory.user?.name || 'N/A' }}</span>
                            </div>

                            <div
                                class="text-xs text-gray-500 dark:text-gray-400 mb-4 pt-2 border-t border-dashed dark:border-gray-700">
                                <p class="font-semibold mb-1">Descripción:</p>
                                <p class="line-clamp-2 text-sm">{{ inventory.description || 'Sin descripción detallada.'
                                }}
                                </p>
                            </div>

                            <div class="flex justify-between text-xs mb-4 p-2 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="text-center">
                                    <span class="font-semibold text-gray-600 dark:text-gray-300">Imp. Compra</span>
                                    <p class="text-indigo-500">{{ inventory.tax_purchase || '0.00' }}%</p>
                                </div>
                                <div class="text-center">
                                    <span class="font-semibold text-gray-600 dark:text-gray-300">Imp. Venta</span>
                                    <p class="text-indigo-500">{{ inventory.tax_sale || '0.00' }}%</p>
                                </div>
                                <div class="text-center">
                                    <span class="font-semibold text-gray-600 dark:text-gray-300">Desc. Máx.</span>
                                    <p class="text-red-500">{{ inventory.max_disscount || '0' }}%</p>
                                </div>
                            </div>

                            <div class="flex justify-between items-center text-sm mb-3 font-semibold">
                                <span class="text-gray-500 dark:text-gray-400">Existencias:</span>
                                <span
                                    :class="inventory.quantityToGenerate < inventory.min_stock ? 'text-red-500 font-bold' : 'text-green-600 font-bold'">
                                    {{ inventory.quantityToGenerate}}
                                    <span class="text-xs text-gray-500"> (Mín: {{ inventory.min_stock }})</span>
                                </span>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Precio Compra:</span>
                                    <span class="text-base font-semibold text-red-500">${{ inventory.profit_detail?.unit_purchase_price
                                    }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Precio Venta:</span>
                                    <span class="text-xl font-bold text-green-600">${{ inventory.profit_detail?.unit_sale_price }}</span>
                                </div>
                                <div class="text-xs text-gray-500 text-right mt-1">
                                    Utilidad Bruta Unitaria: {{ $getFormatCurrency(inventory.profit_detail?.unit_profit_after_tax) }} ({{
                                        $getFormatDecimal((inventory.profit_detail?.unit_profit_percent) )}}%)
                                </div>
                            </div>

                            <div class="mt-4 text-xs text-gray-500 dark:text-gray-400 border-t pt-3">
                                <p class="font-semibold mb-1">Proveedor:</p>
                                <p class="truncate"><b>{{ inventory.supplier_info ? inventory.supplier_info.name :
                                    'Sin-proveedor' }}</b>
                                </p>
                                <p class="truncate"><b>Contacto :</b> {{ inventory.supplier_info ?
                                    inventory.supplier_info.phone
                                    : 'Sin contacto' }}
                                </p>
                                <p class="truncate">Factura: {{ inventory.number_invoice || 'N/A' }}</p>
                                <p>Ingresado: {{ new Date(inventory.created_at).toLocaleDateString() }}</p>
                                <p>Días en Inventario: {{ inventory.days_in_inventory }}</p>
                            </div>

                        </div>

                        <div class="p-4 border-t border-gray-100 dark:border-gray-700">


                            <div class="flex items-center gap-3">

                                <input type="number" v-model.number="inventory.quantityToGenerate"
                                    placeholder="Cantidad" min="1"
                                    class="w-1/5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base py-2 focus:ring-brand focus:border-brand block px-2.5 py-0 shadow-xs" />

                                <button @click.prevent="generateBarcodes(inventory)"
                                    :disabled="inventory.quantityToGenerate < 1" class="
                                    w-full

                                    gradient-button
                                    py-2 px-6
                                    rounded-lg
                                    font-semibold
                                    shadow-md hover:shadow-lg
                                    focus:outline-none focus:ring-4
                                    transition duration-150
                                    text-white
                                    flex items-center justify-center gap-2">

                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill="currentColor" d="M3 5h18v14H3z" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <rect x="6" y="7" width="1" height="10" fill="currentColor" />
                                        <rect x="8" y="7" width="1" height="10" fill="currentColor" />
                                        <rect x="10" y="7" width="1" height="10" fill="currentColor" />
                                        <rect x="12" y="7" width="1" height="10" fill="currentColor" />
                                        <rect x="15" y="7" width="2" height="10" fill="currentColor" />
                                        <rect x="18" y="7" width="1" height="10" fill="currentColor" />
                                    </svg>

                                    <span>Generar Código</span>
                                </button>
                            </div>

                            <button @click="openUpdateModal(inventory)"
                                class=" mt-2 w-full py-2 px-6 rounded-lg font-semibold shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-yellow-300 transition duration-150 text-white bg-yellow-500 hover:bg-yellow-600 flex items-center justify-center space-x-2">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 4h2m7 2l-9 9-4 1 1-4 9-9" />
                                </svg>
                                <span>Editar Producto</span>
                            </button>
                        </div>
                    </div>
                </div>

                <nav v-if="totalPages > 1"
                    class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700 mt-4 p-2"
                    aria-label="Table navigation">
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        Mostrando
                        <span class="font-semibold text-gray-900 dark:text-white">{{ startIndex + 1 }} - {{ endIndex
                            }}</span>
                        de
                        <span class="font-semibold text-gray-900 dark:text-white">{{ pagination.total }}</span>
                        productos
                    </span>
                    <ul class="inline-flex -space-x-px text-sm">
                        <li>
                            <button @click="prevPage" :disabled="currentPage === 1"
                                class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white disabled:opacity-50 disabled:cursor-not-allowed">
                                Anterior
                            </button>
                        </li>
                        <!--<li v-for="page in totalPages" :key="page" v-if="shouldShowPage(page)">
                            <button @click="goToPage(page)"
                                :class="[page === currentPage ? 'text-indigo-600 bg-indigo-50 border-indigo-300 dark:bg-indigo-900/50 dark:text-white' : 'text-gray-500 bg-white border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white']"
                                class="flex items-center justify-center px-3 h-8 leading-tight border">
                                {{ page }}
                            </button>
                        </li>-->
                        <li>
                            <button @click="nextPage" :disabled="currentPage === totalPages"
                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white disabled:opacity-50 disabled:cursor-not-allowed">
                                Siguiente
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <UpdateDataInventoryFormModal v-model="isUpdateModalOpen" :inventory-data="selectedinventory"
            @dataUpdated="handleDataUpdated" />
    </div>
</template>

<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import api from '@/plugins/axios'
import HeaderButtonGenInformComplet from '../components/HeaderButtonGenInformComplet.vue'
import UpdateDataInventoryFormModal from '@/components/modals/UpdateDataInventoryFormModal.vue';


import { useAuthStore } from '@/stores/useAuthStore'
const authStore = useAuthStore()
const isUpdateModalOpen = ref(false)
const selectedinventory = ref(null)
const inventory = ref(null)



const openUpdateModal = (inventoryObject) => {
    selectedinventory.value = inventoryObject;
    // selectedClient.value = clientObject;
    isUpdateModalOpen.value = true;// Abre solo el modal de actualización

    console.log('Abriendo modal de Actualización para ID:', inventoryObject);
}
const closeUpdateModal = () => {
    isUpdateModalOpen.value = false
    selectedinventory.value = null
}
const handleDataUpdated = () => {
    isUpdateModalOpen.value = false; //
    // selectedClient.value = clientObject;
    selectedinventory.value = null;

    console.log('Datos del cliente actualizados. Recargando lista...');
    // Cuando los datos cambian, recarga la lista para reflejar los cambios
    fetchInventories();
    // También podrías considerar cerrar el modal si el modal hijo no lo hace:
    // isUpdateModalOpen.value = false;
}


// --- VARIABLES REACTIVAS ---
// *** Cambiado de 'receivables' a 'inventories' ***
const inventories = ref([]) // Contiene los datos paginados de la página actual
const loading = ref(true)
const error = ref(null)
const searchQuery = ref(''); // Para el input de búsqueda

// Variables de Paginación impulsada por el servidor
const perPage = ref(5); // Inicializado en 10, se debe agregar el <select> en el template
const pagination = ref({
    current_page: 1,
    last_page: 1,
    total: 0,
    from: 0,
    to: 0,
    prev_page_url: null,
    next_page_url: null,
});

// --- VARIABLES COMPUTADAS PARA LA VISTA ---
const totalPages = computed(() => pagination.value.last_page);
const currentPage = computed(() => pagination.value.current_page);
const startIndex = computed(() => pagination.value.from - 1);
const endIndex = computed(() => pagination.value.to);
// *** Renombrado, aunque el v-for usa 'inventories' directamente ***
const currentInventories = computed(() => inventories.value);


// --- LÓGICA DE PAGINACIÓN ---

// Función para determinar qué botones de página mostrar
const shouldShowPage = (page) => {
    const currentPageVal = pagination.value.current_page;
    const lastPageVal = pagination.value.last_page;

    if (lastPageVal <= 7) {
        return true;
    }

    // Muestra las primeras 3, las últimas 3 y las 2 adyacentes a la actual
    if (page === 1 || page === lastPageVal ||
        (page >= currentPageVal - 2 && page <= currentPageVal + 2)) {
        return true;
    }
    return false;
};

const emit = defineEmits(['last-number-received']);


// --- FUNCIÓN PRINCIPAL DE CONSULTA A LA API ---
// *** Cambiado de 'fetchReceivables' a 'fetchInventories' ***
const fetchInventories = async (page = 1) => {
    loading.value = true
    error.value = null
    try {
        // 🎯 Ajuste: URL de la API adaptada a Inventario
        const { data } = await api.get('/inventories/branch', {
            params: {
                page: page,
                per_page: perPage.value,
                search: searchQuery.value, // Envía el término de búsqueda
            }
        })
        // 1. Asignar datos (solo los items de la página actual)
        // Se asume que los datos están bajo data.data.inventories (estructura Laravel con paginación)
        const inventoriesData = data.data.inventories;

        inventories.value = inventoriesData.data || [];

        // 2. Asignar la información de paginación
        if (inventoriesData) {
            pagination.value = {
                current_page: inventoriesData.current_page,
                last_page: inventoriesData.last_page,
                total: inventoriesData.total,
                from: inventoriesData.from,
                to: inventoriesData.to,
                prev_page_url: inventoriesData.prev_page_url,
                next_page_url: inventoriesData.next_page_url,
            };
        } else {
            pagination.value = { current_page: 1, last_page: 1, total: 0, from: 0, to: 0 };
        }

        console.log('que valor de search  ::: ', data.data.last_number);
        emit("last-number-received", {
            lastNumber: data.data.last_number // Asegúrate de que esta ruta sea correcta
        });


        console.log('Inventarios cargados:', inventories.value);

        /*Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Inventario cargado con éxito.",
            showConfirmButton: false,
            timer: 1500
        });*/

    } catch (err) {
        error.value = 'No se pudo cargar el inventario';
        console.error(err);
        Swal.fire('Error', 'No se pudo cargar el inventario.', 'error');
    } finally {
        loading.value = false
    }
}

// Función para manejar el cambio de página
const goToPage = (page) => {
    if (page >= 1 && page <= pagination.value.last_page) {
        fetchInventories(page);
    }
};

// Funciones de navegación
const prevPage = () => {
    goToPage(pagination.value.current_page - 1);
};

const nextPage = () => {
    goToPage(pagination.value.current_page + 1);
};

// --- WATCHERS (Observadores) ---

// Observa cambios en el término de búsqueda y aplica debounce
/*watch(searchQuery, () => {
    if (window.searchTimer) {
        clearTimeout(window.searchTimer);
    }
    window.searchTimer = setTimeout(() => {
        // Al buscar, siempre volvemos a la página 1
        fetchInventories(1);
    }, 300); // Espera 300ms después de la última tecla
});*/

// --- INICIALIZACIÓN ---

onMounted(() => {
    // Inicializar la búsqueda y carga al montar el componente
    fetchInventories();
})

// Funciones para los botones de acción (Ejemplos - deben ser implementadas)
// Nueva función para generar códigos de barras
const generateBarcodes = async (inventory) => {
    const maxAvailable = inventory.quantity - inventory.output_unit;
    const quantity = inventory.quantityToGenerate;
    const product = inventory.sku;

    console.log('valor de generate :: ' + quantity)
    console.log('maxAvailable :: ' + maxAvailable)

    if (quantity === null || typeof quantity !== 'number' || quantity <= 0) {
        Swal.fire('Error', 'Por favor, ingrese una cantidad válida (mayor que 0).', 'error');
        return;
    }

    if (quantity > maxAvailable) {
        Swal.fire({
            icon: 'warning',
            title: 'Stock Insuficiente',
            text: `Solo puedes generar hasta ${maxAvailable} códigos. La cantidad ingresada (${quantity}) excede el stock disponible.`,
        });
        return;
    }

    const requestData = {
        items_to_generate: [
            {
                inventory_id: inventory.id,
                quantity: quantity,
            },
        ],
    };

    try {
        const response = await api.post('/inventory/generateBarcodes', requestData, {
            responseType: 'blob'
        });

        if (response.status === 200 && response.data.size > 0) {

            const blob = new Blob([response.data], { type: 'application/pdf' });
            const downloadUrl = window.URL.createObjectURL(blob);

            let filename = `Etiquetas_${inventory.id}_${Date.now()}.pdf`;
            const contentDisposition = response.headers['content-disposition'];
            if (contentDisposition) {
                const filenameMatch = contentDisposition.match(/filename\*?=(?:UTF-8'')?([\w.-]+)/i);
                if (filenameMatch && filenameMatch[1]) {
                    filename = decodeURIComponent(filenameMatch[1]);
                }
            }

            const link = document.createElement('a');
            link.href = downloadUrl;
            link.setAttribute('download', filename);
            document.body.appendChild(link);
            link.click();

            window.URL.revokeObjectURL(downloadUrl);
            document.body.removeChild(link);

            /*Swal.fire({
                icon: "success",
                title: "PDF generado y descargado",
                text: `El archivo "${filename}" ha sido descargado.`,
            });*/

            Swal.fire({
                position: "top-end",
                icon: "success",
                title: `El archivo con los código de barras del producto ${product} ha sido descargado.`,
                showConfirmButton: false,
                timer: 1500
            });

        } else if (response.status === 200 && response.data.size === 0) {
            Swal.fire('Advertencia', 'El servidor respondió exitosamente, pero el archivo PDF está vacío.', 'warning');
        } else {
            Swal.fire({
                icon: "error",
                title: "Respuesta Inesperada",
                text: `El servidor respondió con el estado ${response.status}.`,
            });
        }

    } catch (err) {
        const errorText = err.response?.data?.message || err.message || 'Fallo en la comunicación con el servidor.';

        Swal.fire({
            icon: "error",
            title: "Error al generar",
            text: errorText,
        });
        console.error('Error al generar códigos de barras y descargar PDF:', err);
    }
};

const editItem = (id) => {
    // Lógica para navegar a la página de edición
    console.log(`Editando producto con ID: ${id}`);
    Swal.fire('Editar Producto', `Abriendo formulario de edición para ID: ${id}.`, 'info');
};

defineExpose({
    fetchInventories,
    generateBarcodes,
    editItem
});
</script>


<style scoped>
/* Estilo para truncar la descripción */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
