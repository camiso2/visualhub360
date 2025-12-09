<template>
    <div class="m-0 p-0 w-full upper-all">

        <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">

            <HeaderButtonGenInformComplet :title="`lista de Proveedores`" :isDopDownVisible = true>
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 3a.75.75 0 00-.75.75V1.5h-1.5a.75.75 0 00-.75.75V3H9.75V1.5a.75.75 0 00-.75-.75H7.5a.75.75 0 00-.75.75V3H6.75A.75.75 0 006 3.75v16.5c0 .414.336.75.75.75h10.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75H15.75zM12 12h.008v.008H12V12zM12 16h.008v.008H12V16zM15.75 8.25V6.75a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0zM8.25 8.25V6.75a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0z" />
                    </svg>
                </template>
            </HeaderButtonGenInformComplet>



            <div class="flex w-full items-center space-x-2 mt-2">
                <input v-model="searchQuery" @keyup.enter="handleSearch"
                    placeholder="Buscar proveedor (nombre, doc, email, tel)..." class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-blue-500 focus:border-blue-500
                                 block w-full px-3 py-2 shadow-xs placeholder:text-body" />


                <button @click="handleSearch" :disabled="loading" class="w-full gradient-button md:w-auto px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700
            disabled:bg-blue-300 transition flex items-center justify-center gap-2">

                    <span v-if="loading" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
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
                    Total de Proveedores: <b>{{ totalSuppliers }}</b>
                </div>

                <div class="flex items-center space-x-2 mt-2 md:mt-0 mr-1">
                    <label for="perPageSelect" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Mostrar
                    </label>
                    <select id="perPageSelect" v-model="perPage" @change="fetchSuppliers(1, searchQuery, perPage)"
                        class="border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option :value="5">5</option>
                        <option :value="10">10</option>
                        <option :value="15">15</option>
                    </select>
                    <span class="text-sm text-gray-500 dark:text-gray-400">filas</span>
                </div>
            </div>
        </div>
        <div v-if="loading" class="text-center p-4 text-indigo-500">
            Cargando proveedores...
        </div>

        <div v-else-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            Error al cargar los proveedores: {{ error }}
        </div>

        <div v-else-if="suppliersData.length === 0"
            class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
            No se encontraron proveedores para esta empresa.
        </div>

        <div v-else class="m-0 p-0 space-y-0 text-gray-600 dark:text-gray-300">

            <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <div class="bg-white mt-4 dark:bg-gray-900 h-[52rem] overflow-y-auto border border-gray-200 dark:border-gray-700 relative">
                 <div class="hidden md:grid grid-cols-8 px-5 py-3 bg-gray-50 dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b border-gray-100 dark:border-gray-700 sticky top-0 z-10">

                        <div class="flex items-center space-x-2 col-span-1">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h14M12 5v14" />
                            </svg>
                            <span>Nombre</span>
                        </div>

                        <div class="flex items-center space-x-2 col-span-1">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5h6m-6 4h6m2 6H7m-2 4h14a2 2 0 002-2V7l-5-5H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <span>Documento</span>
                        </div>

                        <div class="flex items-center space-x-2 col-span-1">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5A2 2 0 003 7v10a2 2 0 002 2z" />
                            </svg>
                            <span>Email</span>
                        </div>

                        <div class="flex items-center space-x-2 col-span-1">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3l2 5-2 1a11 11 0 006 6l1-2 5 2v3a2 2 0 01-2 2h-1A16 16 0 013 5z" />
                            </svg>
                            <span>Teléfono</span>
                        </div>

                        <div class="flex items-center space-x-2 col-span-1">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3zm0 0c4.418 0 8 2.239 8 5v2H4v-2c0-2.761 3.582-5 8-5z" />
                            </svg>
                            <span>Dirección</span>
                        </div>

                        <div class="flex items-center space-x-2 col-span-1">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h3V5H5a2 2 0 00-2 2zm13-2v14h3a2 2 0 002-2V7a2 2 0 00-2-2h-3z" />
                            </svg>
                            <span>Fecha Reg.</span>
                        </div>

                        <div class="flex items-center space-x-2 col-span-1">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Estado</span>
                        </div>
                        <div class="flex items-center space-x-2 col-span-1">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 3a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 7a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 7a1.5 1.5 0 110-3 1.5 1.5 0 010 3z" />
                            </svg>
                            <span>Acciones </span>
                        </div>
                    </div>

                    <div v-for="supplier in suppliersData" :key="supplier.id"
                        class="grid grid-cols-1 md:grid-cols-8 px-5 py-4 text-sm border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-150">

                        <div class="col-span-1">
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Nombre&nbsp;</span>
                            <span class="font-medium">{{ supplier.name }}</span>
                        </div>

                        <div class="col-span-1">
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Documento&nbsp;</span>
                            <span>{{ supplier.document }}</span>
                        </div>

                        <div class="col-span-1">
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Email&nbsp;</span>
                            <span class="text-blue-700 dark:text-blue-400 break-words">{{ supplier.email }}</span>
                        </div>

                        <div class="col-span-1">
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Teléfono&nbsp;</span>
                            <span>{{ supplier.phone }}</span>
                        </div>

                        <div class="col-span-1">
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Dirección&nbsp;</span>
                            <span>{{ supplier.address }}<br>{{ supplier.city }} - {{ supplier.country }}</span>
                        </div>

                        <div class="col-span-1">
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Fecha Registro&nbsp;</span>
                            <span>
                                {{
                                    new Date(supplier.created_at).toLocaleDateString('es-CO', {
                                        year: 'numeric',
                                        month: '2-digit',
                                        day: '2-digit',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    })
                                }}
                            </span>
                        </div>

                        <div class="col-span-1">
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Estado&nbsp;</span>
                            <span :class="supplier.active
                                ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'
                                : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300'"
                                class="px-3 py-1 text-xs font-semibold rounded-full w-fit">
                                {{ supplier.active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>

                        <div class="flex flex-col mt-0 md:flex-row items-center gap-2 mt-0 md:mt-0 w-full">
                            <div class="w-full">
                                <button @click="openUpdateModal(supplier)" :disabled="loading" class="flex items-center justify-center space-x-2 bg-yellow-500 hover:bg-yellow-600 text-white
        px-4 h-9 rounded-lg text-sm font-medium transition-all shadow-md
        hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-yellow-400
        focus:ring-offset-1 w-full">
                                    <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 4h2m7.121 2.879l-2 2L9 17l-4 1 1-4 9.121-9.121a2 2 0 112.828 2.828z" />
                                    </svg>
                                    <span class="leading-snug whitespace-nowrap text-center">
                                        {{ loading ? 'Editar Proveedor...' : 'Editar Proveedor' }}
                                    </span>
                                </button>
                            </div>
                        </div>

                    </div>

                    <div v-if="totalPages > 1"
                        class="flex flex-col md:flex-row items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-b-xl border-t border-gray-200 dark:border-gray-700">

                        <span class="text-sm text-gray-700 dark:text-gray-400 mb-2 md:mb-0">
                            Mostrando
                            <span class="font-semibold text-gray-900 dark:text-white">{{ paginationStatus.from }}</span>
                            a
                            <span class="font-semibold text-gray-900 dark:text-white">{{ paginationStatus.to }}</span>
                            de
                            <span class="font-semibold text-gray-900 dark:text-white">{{ totalSuppliers }}</span>
                            proveedores.
                        </span>

                        <div class="inline-flex rounded-md shadow-sm -space-x-px" role="group">
                            <button @click="prevPage" :disabled="currentPage === 1" class="px-3 py-1.5 text-gray-700
            border border-gray-300 rounded-l-md
            hover:bg-gray-50 disabled:bg-white disabled:opacity-50 disabled:cursor-not-allowed
            transition-colors duration-150">
                                Anterior
                            </button>
                            <button @click="nextPage" :disabled="currentPage === totalPages" class="px-3 py-1.5 text-gray-700
            border border-gray-300 rounded-r-md
            hover:bg-gray-50 disabled:bg-white disabled:opacity-50 disabled:cursor-not-allowed
            transition-colors duration-150">
                                Siguiente
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <UpdateDataSupplierFormModal v-model="isUpdateModalOpen" :supplier-data="selectedSupplier"
            @supplierUpdated="handleDataUpdated" />
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import api from '@/plugins/axios';
import HeaderButtonGenInformComplet from '../components/HeaderButtonGenInformComplet.vue'
import UpdateDataSupplierFormModal from '@/components/modals/UpdateDataSupplierFormModal.vue';
import { useAuthStore } from '@/stores/useAuthStore'
const authStore = useAuthStore()
const isUpdateModalOpen = ref(false)
const selectedSupplier = ref(null)

const openUpdateModal = (supplierObject) => {
    selectedSupplier.value = supplierObject;
    // selectedClient.value = clientObject;
    isUpdateModalOpen.value = true;// Abre solo el modal de actualización

    console.log('Abriendo modal de Actualización para ID:', supplierObject);
}
const closeUpdateModal = () => {
    isUpdateModalOpen.value = false
    selectedSupplier.value = null
}
const handleDataUpdated = () => {
    isUpdateModalOpen.value = false; //
    // selectedClient.value = clientObject;
    selectedSupplier.value = null;

    console.log('Datos del cliente actualizados. Recargando lista...');
    // Cuando los datos cambian, recarga la lista para reflejar los cambios
    fetchSuppliers();
    // También podrías considerar cerrar el modal si el modal hijo no lo hace:
    // isUpdateModalOpen.value = false;
}

// --- Variables de Estado ---
const suppliersData = ref([]); // La data real de la página actual.
const loading = ref(true);
const error = ref(null);

// --- Variables de Paginación y Búsqueda (Controladas por el Backend) ---
const currentPage = ref(1);
const totalPages = ref(1);
const totalSuppliers = ref(0);
const perPage = ref(10); // Valor por defecto para enviar al backend

const searchQuery = ref(''); // Término de búsqueda

// --- 🎯 PROPIEDADES COMPUTADAS CLAVE (Ajustadas para Paginación de Backend) ---

// 1. Array de Proveedores para la Página Actual: Solo devuelve los datos cargados.
const pagedSuppliers = computed(() => {
    return suppliersData.value;
});

// 2. Calcula el estado actual de la paginación (from/to)
const paginationStatus = computed(() => {
    const from = totalSuppliers.value === 0 ? 0 : (currentPage.value - 1) * perPage.value + 1;
    const to = Math.min(currentPage.value * perPage.value, totalSuppliers.value);
    return { from, to };
});

// 3. Genera un array de páginas visibles (Simplificado)
const visiblePages = computed(() => {
    // Si necesitas el listado de botones de paginación, puedes usar esta lógica:
    const pages = [];
    const maxVisible = 5;
    let startPage = Math.max(1, currentPage.value - Math.floor(maxVisible / 2));
    let endPage = Math.min(totalPages.value, startPage + maxVisible - 1);

    if (endPage - startPage + 1 < maxVisible) {
        startPage = Math.max(1, endPage - maxVisible + 1);
    }

    for (let i = startPage; i <= endPage; i++) {
        pages.push(i);
    }
    return pages;
});

// --- Función de Carga de Proveedores (Delegada al Backend) ---
const fetchSuppliers = async (page = 1, search = '', limit = perPage.value) => {
    loading.value = true;
    error.value = null;

    try {
        const params = {
            page: page,
            search: search,
            per_page: limit // Envía el límite por página al backend
        };

        const response = await api.get('/suppliers', { params }); // NOTA: Ajusté la ruta a '/suppliers' si es la pública. Si es `/admin/suppliers` úsala.

        // 🎯 Extrae la data de paginación de la nueva estructura: response.data.data.suppliers
        const paginatedData = response.data.data.suppliers;

        // 4. Actualiza las variables de estado con la info del backend
        suppliersData.value = paginatedData.data || [];
        currentPage.value = paginatedData.current_page;
        totalSuppliers.value = response.data.count; // Total de proveedores filtrados/sin filtrar
        totalPages.value = paginatedData.last_page || 1;
        perPage.value = paginatedData.per_page; // Actualiza el perPage con el valor del backend (si es diferente)

        console.log('Proveedores Obtenidos (Página ' + currentPage.value + '): ', suppliersData.value)

       /* Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Proveedores obtenidos con éxito !",
            showConfirmButton: false,
            timer: 1500
        });*/

    } catch (err) {
        error.value = err.message || 'Error desconocido del servidor.';
        console.error("Error al obtener suppliers:", err);
    } finally {
        loading.value = false;
    }
};

// --- Métodos de Interacción (Ahora llaman a fetchSuppliers) ---

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value && page !== currentPage.value) {
        // Llama al backend con la nueva página, el término de búsqueda actual y el perPage
        fetchSuppliers(page, searchQuery.value, perPage.value);
    }
};

const nextPage = () => {
    goToPage(currentPage.value + 1);
};

const prevPage = () => {
    goToPage(currentPage.value - 1);
};

const handleSearch = () => {
    // Al buscar, siempre se debe resetear la paginación a la página 1
    // y cargar los datos con el término de búsqueda.
    fetchSuppliers(1, searchQuery.value, perPage.value);
};


const editClient = (supplier) => {
    // Simular función de edición
    console.log("Editando proveedor:", supplier.id);
};


defineExpose({
    fetchSuppliers
});

onMounted(() => {
    // Carga inicial de la página 1 sin búsqueda.
    fetchSuppliers();
});
</script>

<style scoped>
/* Tu estilo Tailwind */
</style>
