<template>
    <div class="p-0 upper-all">

        <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">


            <HeaderButtonGenInformComplet :title="`Lista de Sucursales `" :isDopDownVisible=true>
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8.25v-2.5m0 0c0-.69-.56-1.25-1.25-1.25H6.25A1.25 1.25 0 005 4.75v14.5c0 .69.56 1.25 1.25 1.25h4.5c.69 0 1.25-.56 1.25-1.25v-2.5m0-12.5h3.5c.69 0 1.25.56 1.25 1.25v3.5m-4.75 7.25h6.5c.69 0 1.25-.56 1.25-1.25V9.75L15.5 6H12m0 8.25H9.75m2.25 3H9.75" />
                    </svg>

                </template>
            </HeaderButtonGenInformComplet>

            <div class="flex w-full items-center space-x-2 mt-2">
                <input v-model="searchQuery" @keyup.enter="handleSearch"
                    placeholder="Buscar Sucursal código / email / nombre..." class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-blue-500 focus:border-blue-500
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
                    Total de sucursales: <b>{{ totalBranches }}</b>
                </div>

                <div class="flex items-center space-x-2 mt-2 md:mt-0 mr-1">
                    <label for="perPageSelect" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Mostrar
                    </label>
                    <select id="perPageSelect" v-model="perPage"
                        class="border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option :value="10">10</option>
                        <option :value="25">25</option>
                        <option :value="50">50</option>
                    </select>
                    <span class="text-sm text-gray-500 dark:text-gray-400">filas</span>
                </div>
            </div>
        </div>

        <div v-if="loading" class="text-center p-4 text-indigo-500">
            Cargando sucursales...
        </div>
        <div v-else-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
            role="alert">
            Error al cargar las sucursales: {{ error }}
        </div>
        <div v-else-if="totalBranches === 0"
            class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
            No se encontraron sucursales.
        </div>
        <div v-else class="m-0 p-0 space-y-0 text-gray-600 dark:text-gray-300">

            <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">

                <div
                    class="bg-white mt-4 dark:bg-gray-900 h-[52rem] overflow-y-auto border border-gray-200 dark:border-gray-700 relative">

                    <div
                        class="hidden md:grid grid-cols-9 px-5 py-3 bg-gray-50 dark:bg-gray-800 sticky top-0
   text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b border-gray-100 dark:border-gray-700">
                        <div class="flex items-center space-x-2">

                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A9 9 0 1119 12.5a4 4 0 01-8 0 4 4 0 118 0" />
                            </svg>

                            <span></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A9 9 0 1119 12.5a9 9 0 01-13.879 5.304z" />
                            </svg>
                            <span>Nombre</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5h6m-6 4h6m2 6H7m-2 4h14a2 2 0 002-2V7l-5-5H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <span>Sucursal</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12h.01M12 12h.01M8 12h.01M21 16V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2z" />
                            </svg>
                            <span>Email</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3l2 5-2 1a11 11 0 006 6l1-2 5 2v3a2 2 0 01-2 2h-1A16 16 0 013 5z" />
                            </svg>
                            <span>Teléfono</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3zm0 0c4.418 0 8 2.239 8 5v2H4v-2c0-2.761 3.582-5 8-5z" />
                            </svg>
                            <span>Dirección</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Estado</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h3V5H5a2 2 0 00-2 2zm13-2v14h3a2 2 0 002-2V7a2 2 0 00-2-2h-3z" />
                            </svg>
                            <span>Fecha Registro</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 4h2m7.121 2.879l-2 2L9 17l-4 1 1-4 9.121-9.121a2 2 0 112.828 2.828z" />
                            </svg>
                            <span>Acciones</span>
                        </div>
                    </div>
                    <div v-for="branch in branchesData" :key="branch.id" class="grid grid-cols-1 md:grid-cols-9 px-5 py-4 text-sm border-b border-gray-100 dark:border-gray-700
   hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-150">
                        <div @click="$openImageViewer(branch.image || '/avatars/default-avatar.png')"
                            class="w-12 h-12 overflow-hidden rounded-md shadow-md border  cursor-pointer group relative">
                            <img :src="`${branch.image}`" :alt="branch.image"
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

                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Nombre&nbsp;&nbsp;</span>
                            <span class="font-medium">{{ branch.name }}</span>
                        </div>

                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Codigo
                                Sucursal&nbsp;&nbsp;</span>
                            <span><b>Código :</b> {{ branch.code }} </span>
                        </div>

                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Email&nbsp;&nbsp;</span>
                            <span class="text-blue-700 dark:text-blue-400">{{ branch.email }}</span>
                        </div>

                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Teléfono&nbsp;&nbsp;</span>
                            <span>{{ branch.phone }}</span>
                        </div>

                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Dirección&nbsp;&nbsp;</span>
                            <span>{{ branch.address }}<br>{{ branch.city }} - {{ branch.department }}</span>
                        </div>

                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Estado&nbsp;&nbsp;</span>
                            <span :class="branch.active
                                ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'
                                : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300'"
                                class="px-3 py-1 text-xs font-semibold rounded-full w-fit">
                                {{ branch.active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Fecha
                                Registro&nbsp;&nbsp;</span>
                            <span>{{ new Date(branch.created_at).toLocaleDateString('es-CO', {
                                year: 'numeric', month: '2-digit', day: '2-digit',
                                hour: '2-digit', minute: '2-digit'
                            }) }}</span>
                        </div>
                        <div class="flex flex-col mt-0 md:flex-row items-center gap-2 mt-0 md:mt-0 w-full">
                            <div class="w-full">
                                <button @click="openUpdateModal(branch)" :disabled="loading" class="flex items-center justify-center space-x-2 bg-yellow-500 hover:bg-yellow-600 text-white
        px-4 h-9 rounded-lg text-sm font-medium transition-all shadow-md
        hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-yellow-400
        focus:ring-offset-1 w-full">
                                    <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 4h2m7.121 2.879l-2 2L9 17l-4 1 1-4 9.121-9.121a2 2 0 112.828 2.828z" />
                                    </svg>
                                    <span class="leading-snug whitespace-nowrap text-center">
                                        {{ loading ? 'Editar Sucursal...' : 'Editar Sucursal' }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <div v-if="totalPages > 1"
                    class="h-16 w-full flex items-center justify-between px-4 text-sm font-medium border-t border-gray-200 bg-white shadow-inner">

                    <p class="text-sm text-gray-700 dark:text-gray-400">
                        Mostrando
                        <span class="font-medium">{{ paginationStatus.from }}</span>
                        a
                        <span class="font-medium">{{ paginationStatus.to }}</span>
                        de
                        <span class="font-medium">{{ totalBranches }}</span>
                        resultados
                    </p>

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
        <UpdateDataBranchFormModal v-model="isUpdateModalOpen" :branch-data="selectedBranch"
            @dataUpdated="handleDataUpdated" />
    </div>
</template>

<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import api from '@/plugins/axios';
import HeaderButtonGenInformComplet from '../components/HeaderButtonGenInformComplet.vue'
import UpdateDataBranchFormModal from '@/components/modals/UpdateDataBranchFormModal.vue';

import { useAuthStore } from '@/stores/useAuthStore'
const authStore = useAuthStore()
const isUpdateModalOpen = ref(false)
const selectedBranch = ref(null)

const openUpdateModal = (branchObject) => {
    selectedBranch.value = branchObject;
    // selectedClient.value = clientObject;
    isUpdateModalOpen.value = true;// Abre solo el modal de actualización

    console.log('Abriendo modal de Actualización para ID:', branchObject);
}
const closeUpdateModal = () => {
    isUpdateModalOpen.value = false
    selectedBranch.value = null
}
const handleDataUpdated = () => {
    isUpdateModalOpen.value = false; //
    // selectedClient.value = clientObject;
    selectedBranch.value = null;

    console.log('Datos del cliente actualizados. Recargando lista...');
    // Cuando los datos cambian, recarga la lista para reflejar los cambios
    fetchBranches();
    // También podrías considerar cerrar el modal si el modal hijo no lo hace:
    // isUpdateModalOpen.value = false;
}


// --- Variables de Datos ---
const branchesData = ref([]); // ✅ Almacena el array de sucursales de la PÁGINA ACTUAL
const loading = ref(true);
const error = ref(null);

// --- Variables de Búsqueda y Paginación Remota ---
const searchQuery = ref('');    // ✅ Para el campo de búsqueda
const currentPage = ref(1);      // ✅ La página que estamos viendo
const perPage = ref(10);         // ✅ Número de ítems por página (enviado al backend)
const totalBranches = ref(0);    // ✅ Total de registros (viene del backend)
const totalPages = ref(1);       // ✅ Total de páginas (viene del backend)

// --- PROPIEDAD COMPUTADA: Status de Paginación ---
const paginationStatus = computed(() => {
    // Calcula qué elementos se están mostrando (por ejemplo: Mostrando 11 a 20 de 50)
    if (totalBranches.value === 0) {
        return { from: 0, to: 0 };
    }
    const from = (currentPage.value - 1) * perPage.value + 1;
    const to = Math.min(currentPage.value * perPage.value, totalBranches.value);
    return { from, to };
});

// --- LÓGICA DE PAGINACIÓN REMOTA ---

// Función unificada para ir a una página (dispara la petición)
const goToPage = (page) => {
    if (page === '...' || page === currentPage.value) return;

    const pageNum = Number(page);
    if (pageNum >= 1 && pageNum <= totalPages.value) {
        currentPage.value = pageNum;
        // Llama a fetchBranches con la nueva página
        fetchBranches(pageNum, searchQuery.value, perPage.value);
    }
};

const prevPage = () => {
    goToPage(currentPage.value - 1);
};

const nextPage = () => {
    goToPage(currentPage.value + 1);
};

// Función para calcular los números de página visibles
const visiblePages = computed(() => {
    const range = 2; // Mostrar 2 páginas a cada lado de la actual
    const pages = [];
    const total = totalPages.value;
    const current = currentPage.value;

    if (total <= 1) return [];

    // Agrega 1 y puntos suspensivos si es necesario
    if (current > range + 1) {
        pages.push(1);
        if (current > range + 2) pages.push('...');
    }

    // Agrega el rango de páginas alrededor de la actual
    for (let i = Math.max(1, current - range); i <= Math.min(total, current + range); i++) {
        pages.push(i);
    }

    // Agrega puntos suspensivos y la última página si es necesario
    if (current < total - range) {
        if (current < total - range - 1) pages.push('...');
        pages.push(total);
    }

    return pages;
});


// --- LÓGICA DE BÚSQUEDA ---
const handleSearch = () => {
    // Siempre que se busca, volvemos a la página 1 con el nuevo término de búsqueda
    fetchBranches(1, searchQuery.value, perPage.value);
};

// --- LÓGICA DE CARGA DE DATOS (AJUSTADA A RESPUESTA REMOTA) ---

// fetchBranches ahora acepta parámetros para paginación y búsqueda
const fetchBranches = async (page = 1, search = '', itemsPerPage = perPage.value) => {
    loading.value = true;
    error.value = null;

    currentPage.value = page;
    perPage.value = itemsPerPage;

    const params = {
        page: page,
        per_page: itemsPerPage,
        search: search,
    };

    try {
        console.log("-> Realizando solicitud a /branches con params:", params); // DEBUG 1

        // Asegúrate de que 'api' esté importado y configurado correctamente (plugins/axios)
        const response = await api.get('/branchess', { params });
        const responseData = response.data;

        console.log("<- Respuesta recibida:", responseData); // DEBUG 2: Revisa esta estructura

        // **PARSEO CRÍTICO DE LA RESPUESTA DEL BACKEND**
        // Tu estructura: response.data -> { data: { branches: { ... } } }
        if (responseData && responseData.data && responseData.data.branches) {
            const backendPaginationObject = responseData.data.branches;

            branchesData.value = backendPaginationObject.data || [];

            // 2. Extraer los metadatos de paginación
            currentPage.value = backendPaginationObject.current_page || 1;
            totalPages.value = backendPaginationObject.last_page || 1;
            totalBranches.value = backendPaginationObject.total || 0;
            perPage.value = backendPaginationObject.per_page || 10;
        } else {
            // Manejo de respuesta inesperada (e.g., body vacío o error 200 sin datos)
            branchesData.value = [];
            totalBranches.value = 0;
            totalPages.value = 1;
            console.error("Estructura de respuesta inesperada:", responseData);
        }

        // ... (Tu código de Swal.fire va aquí, si lo mantienes)

    } catch (err) {
        error.value = err.message || 'Error desconocido del servidor.';
        console.error("Error al obtener sucursales (Network/API Error):", err);
        branchesData.value = [];
        totalBranches.value = 0;
        totalPages.value = 1;
        // ... (Tu código de Swal.fire para error va aquí)
    } finally {
        loading.value = false;
        console.log("-> Carga finalizada. Total Items:", totalBranches.value); // DEBUG 3
    }
};

// Observa el cambio en perPage y dispara una nueva búsqueda desde la página 1,
// conservando el término de búsqueda actual.
watch(perPage, (newVal) => {
    fetchBranches(1, searchQuery.value, newVal);
});

// Nota: No es necesario observar searchQuery, ya que se maneja a través de
// @keyup.enter y @click en el botón de búsqueda, que llama a handleSearch/fetchBranches(1).


// Función de ejemplo para editar (debes implementarla)
const editClient = (client) => {
    // Lógica para abrir modal de edición o navegar a la ruta de edición
    console.log("Editando cliente:", client.name);
};


defineExpose({
    fetchBranches
});

onMounted(() => {
    // Llama a la carga inicial al montar
    fetchBranches(currentPage.value, searchQuery.value, perPage.value);
});
</script>
