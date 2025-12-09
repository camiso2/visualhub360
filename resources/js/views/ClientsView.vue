<template>
    <div class="m-0 p-0 w-full upper-all">

        <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <HeaderButtonGenInformComplet :title="`Lista de Clientes `" :isDopDownVisible=true>
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8.25v-2.5m0 0c0-.69-.56-1.25-1.25-1.25H6.25A1.25 1.25 0 005 4.75v14.5c0 .69.56 1.25 1.25 1.25h4.5c.69 0 1.25-.56 1.25-1.25v-2.5m0-12.5h3.5c.69 0 1.25.56 1.25 1.25v3.5m-4.75 7.25h6.5c.69 0 1.25-.56 1.25-1.25V9.75L15.5 6H12m0 8.25H9.75m2.25 3H9.75" />
                    </svg>

                </template>
            </HeaderButtonGenInformComplet>

            <div class="flex w-full items-center space-x-2">
                <input type="text" placeholder="Buscar cliente..." v-model="searchQuery" @keyup.enter="handleSearch"
                    class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body" />



                <button @click="handleSearch" :disabled="loading" class="w-full gradient-button md:w-auto px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700
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
                    Total de Clientes: <b>{{ totalClients }}</b>
                </div>

                <div class="flex items-center space-x-2 mt-2 md:mt-0 mr-1">
                    <label for="perPageSelect" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Mostrar
                    </label>
                    <select id="perPageSelect" v-model="perPage" @change="fetchClients(1)"
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
            Cargando clientes...
        </div>
        <div v-else-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
            role="alert">
            Error al cargar los clientes: {{ error }}
        </div>
        <div v-else-if="clients.length === 0 && !searchQuery && allClients.length === 0"
            class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
            No se encontraron clientes para esta empresa.
        </div>
        <div v-else-if="clients.length === 0 && searchQuery"
            class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
            No se encontraron clientes que coincidan con "{{ searchQuery }}".
        </div>

        <div v-else class="m-0 p-0 space-y-0 text-gray-600 dark:text-gray-300">


            <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">


                <div
                    class="bg-white mt-4 dark:bg-gray-900 h-[52rem] overflow-y-auto border border-gray-200 dark:border-gray-700 relative">


                    <div
                        class="hidden md:grid grid-cols-10 px-5 py-3 bg-gray-50 dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide border-b border-gray-100 dark:border-gray-700">
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A9 9 0 1119 12.5c0 2.485-1.5 4.5-3.5 4.5h-2l-2 4-2-4h-2a4 4 0 01-3.379-1.196z" />
                            </svg>
                            <span>Nombre</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5h6m-6 4h6m2 6H7m-2 4h14a2 2 0 002-2V7l-5-5H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <span>Documento</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5A2 2 0 003 7v10a2 2 0 002 2z" />
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
                                    d="M3 7v10a2 2 0 002 2h3V5H5a2 2 0 00-2 2zm13-2v14h3a2 2 0 002-2V7a2 2 0 00-2-2h-3z" />
                            </svg>
                            <span>Fecha Registro</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            <span>Sucursal</span>
                        </div>
                        <div class="flex items-center space-x-2 w-20"> <svg class="h-4 w-4" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Estado</span>
                        </div>
                        <div class="flex items-center space-x-2 w-30">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 3a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 7a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 7a1.5 1.5 0 110-3 1.5 1.5 0 010 3z" />
                            </svg>
                            <span>Acciones </span>
                        </div>
                    </div>
                    <div v-for="client in clients" :key="client.id" class="grid grid-cols-1 md:grid-cols-10 px-5 py-4 text-sm border-b border-gray-100 dark:border-gray-700
                        hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-150">

                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Nombre&nbsp;&nbsp;</span>
                            <span class="font-medium"><b>{{ $capitalizeWords(client.name) }}</b></span>
                        </div>
                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Documento&nbsp;&nbsp;</span>
                            <span>{{ client.document_type }} {{ client.document_number }}</span>
                        </div>
                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Email&nbsp;&nbsp;</span>
                            <span class="text-blue-700 dark:text-blue-400">{{ client.email }}</span>
                        </div>
                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Teléfono&nbsp;&nbsp;</span>
                            <span>{{ client.phone }}</span>
                        </div>
                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Dirección&nbsp;&nbsp;</span>
                            <span>{{ client.address }}<br>{{ client.city }} - {{ client.department }}</span>
                        </div>
                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Fecha
                                Registro&nbsp;&nbsp;</span>
                            <span>{{ new Date(client.created_at).toLocaleDateString('es-CO', {
                                year: 'numeric', month: '2-digit', day: '2-digit',
                                hour: '2-digit', minute: '2-digit'
                            }) }}</span>
                        </div>
                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Sucursal&nbsp;&nbsp;</span>

                            <div class="flex flex-col">
                                <span class="font-semibold"><b>Registrado en :</b> {{ client.branch?.name || 'sin datos'
                                }}</span>
                                <span class="text-[11px] text-gray-400 dark:text-gray-500">
                                    <b>Contacto: </b>{{ client.branch?.phone ?? 'sin datos' }}
                                </span>
                            </div>
                        </div>
                        <div class="w-8"> <span class="md:hidden text-gray-400 text-xs font-semibold">Estado</span>
                            <span :class="client.active
                                ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'
                                : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300'"
                                class="px-3 py-1 text-xs font-semibold rounded-full w-fit">
                                {{ client.active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                        <div class="flex flex-col md:flex-row items-center gap-2 mt-0 md:mt-0 w-full">
                            <div class="w-full">
                                <button @click="openUpdateModal(client)" :disabled="loading" class="flex items-center justify-center space-x-2 bg-yellow-500 hover:bg-yellow-600 text-white
        px-4 h-9 rounded-lg text-sm font-medium transition-all shadow-md
        hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-yellow-400
        focus:ring-offset-1 w-full">
                                    <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 4h2m7.121 2.879l-2 2L9 17l-4 1 1-4 9.121-9.121a2 2 0 112.828 2.828z" />
                                    </svg>
                                    <span class="leading-snug whitespace-nowrap text-center">
                                        {{ loading ? 'Editar Cliente...' : 'Edit' }}
                                    </span>
                                </button>
                            </div>
                            <div class="w-full">
                                <RouterLink :to="{ name: 'DocumentsClient', params: { id: client.id } }"
                                    :disabled="loading" class="flex items-center justify-center mt-0 cpy-2 px-6 border border-transparent
           rounded-lg h-9 shadow-md text-sm font-medium text-white
           bg-zinc-600 hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 transition duration-150
           w-full md:w-auto text-center">
                                    <svg v-if="loading" class="animate-spin mr-3 h-5 w-5 text-white"
                                        viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2.01 5.938A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>

                                    <svg v-else class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <span class="leading-snug whitespace-nowrap text-center">
                                        {{ loading ? 'Cargando...' : 'Ver Doc.' }}
                                    </span>
                                </RouterLink>
                            </div>
                            <div class="w-full">
                                <button @click="openDocumentModal(client.id)" :disabled="loading" class="flex items-center justify-center mt-0 cpy-2 px-6 border border-transparent
        rounded-lg h-9  shadow-md text-sm font-medium text-white
        bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 transition duration-150
        w-full md:w-auto text-center ">
                                    <svg v-if="loading" class="animate-spin mr-3 h-5 w-5 text-white"
                                        viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4">
                                        </circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2.01 5.938A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>

                                    <svg v-else class="mr-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>

                                    <span class="leading-snug whitespace-nowrap text-center">
                                        {{ loading ? 'Agregando Documento...' : 'Agregar Doc...' }}
                                    </span>
                                </button>
                            </div>
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
                        <span class="font-semibold text-gray-900 dark:text-white">{{ totalClients }}</span>
                        clientes.
                    </span>

                    <div class="inline-flex rounded-md shadow-sm -space-x-px" role="group">
                        <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1" class="px-3 py-1.5 text-gray-700
            border border-gray-300 rounded-l-md
            hover:bg-gray-50 disabled:bg-white disabled:opacity-50 disabled:cursor-not-allowed
            transition-colors duration-150">
                            Anterior
                        </button>
                        <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages" class="px-3 py-1.5 text-gray-700
            border border-gray-300 rounded-r-md
            hover:bg-gray-50 disabled:bg-white disabled:opacity-50 disabled:cursor-not-allowed
            transition-colors duration-150">
                            Siguiente
                        </button>
                    </div>
                </div>
                <ClientDocumentFormModal v-model="isDocumentModalOpen" :client-id="selectedClientId"
                    @documentSaved="handleDocumentSaved" />

                <UpdateDataClientFormModal v-model="isUpdateModalOpen" :client-data="selectedClient"
                    @dataUpdated="handleDataUpdated" />



            </div>
        </div>

    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import api from '@/plugins/axios';
import HeaderButtonGenInformComplet from '../components/HeaderButtonGenInformComplet.vue'

import ClientDocumentFormModal from '@/components/modals/ClientDocumentFormModal.vue';
import UpdateDataClientFormModal from '@/components/modals/UpdateDataClientFormModal.vue';

import { useAuthStore } from '@/stores/useAuthStore'
const authStore = useAuthStore()
const isDocumentModalOpen = ref(false);
const isUpdateModalOpen = ref(false);
const selectedClientId = ref(null);
const selectedClient = ref(null);
const openDocumentModal = (clientId) => {
    selectedClientId.value = clientId;
    isDocumentModalOpen.value = true; // Abre solo el modal de documentos
    console.log('Abriendo modal de Documentos para ID:', clientId);
}
const openUpdateModal = (clientObject) => {
    selectedClient.value = clientObject;
   // selectedClient.value = clientObject;
    isUpdateModalOpen.value = true;// Abre solo el modal de actualización
    console.log('Abriendo modal de Actualización para ID:', clientObject);
}
// Función que se ejecuta cuando el componente hijo termina de guardar el documento
const handleDocumentSaved = () => {
    isDocumentModalOpen.value = false; //

    console.log('Documento guardado. Recargar la lista de documentos.');
    // Si necesitas recargar la lista de clientes general, podrías hacer:
    // fetchClients(currentPage.value, searchQuery.value);
}
const handleDataUpdated = () => {
    isUpdateModalOpen.value = false; //
   // selectedClient.value = clientObject;
   selectedClient.value = null;
    console.log('Datos del cliente actualizados. Recargando lista...');
    // Cuando los datos cambian, recarga la lista para reflejar los cambios
    fetchClients();
    // También podrías considerar cerrar el modal si el modal hijo no lo hace:
    // isUpdateModalOpen.value = false;
}



// --- Variables de Estado (Ajustadas para Paginación de Backend) ---
const clientsData = ref([]);
const currentPage = ref(1);
const totalPages = ref(1);
const totalClients = ref(0);
// 🎯 AÑADIDO: La variable para controlar cuántos elementos mostrar por página
const perPage = ref(8);

const searchQuery = ref('');
const loading = ref(true);
const error = ref(null);


// --- 🎯 PROPIEDADES COMPUTADAS CLAVE (Ajustadas) ---

const clients = computed(() => {
    // Devuelve la data de la página actual cargada por el backend
    return clientsData.value;
});

// Calcula el estado actual de la paginación (from/to)
const paginationStatus = computed(() => {
    const from = totalClients.value === 0 ? 0 : (currentPage.value - 1) * perPage.value + 1;
    const to = Math.min(currentPage.value * perPage.value, totalClients.value);
    return { from, to };
});

// Genera un array de páginas visibles (se mantiene la lógica)
const visiblePages = computed(() => {
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


// --- Función de Carga de Clientes (Ajustada para enviar per_page) ---
const fetchClients = async (page = 1, search = '') => {
    loading.value = true;
    error.value = null;

    try {
        // 1. Construye los parámetros de la URL
        const params = {
            page: page,
            search: search,
            per_page: perPage.value
        };

        // 2. Llama a la API con los parámetros
        const response = await api.get(`/clients`, { params });

        // 3. Extrae la data de paginación
        const paginatedData = response.data.data.clients;

        // 4. Actualiza las variables de estado con la info del backend
        clientsData.value = paginatedData.data || [];
        currentPage.value = paginatedData.current_page;
        totalClients.value = response.data.count; // Total de clientes filtrados/sin filtrar
        totalPages.value = paginatedData.last_page || 1;

        // 🎯 Opcional: Actualizar perPage con el valor del backend, aunque lo controlamos localmente
        perPage.value = paginatedData.per_page;

        console.log(' Clientes Obtenidos (Página ' + currentPage.value + ', ' + perPage.value + ' por pág): ', clientsData.value)



    } catch (err) {
        error.value = err.message || 'Error desconocido del servidor.';
        console.error("Error al obtener clientes:", err);
    } finally {
        loading.value = false;
    }
};

// --- Métodos de Interacción ---

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value && page !== currentPage.value) {
        // Llama al backend con la nueva página, el término de búsqueda actual y el perPage
        fetchClients(page, searchQuery.value);
    }
};

// 🎯 handleSearch ahora llama a fetchClients
const handleSearch = () => {
    // Al buscar, se resetea a la página 1 y se usa el perPage actual.
    fetchClients(1, searchQuery.value);
};

// Placeholder para la función de editar
const editClient = (client) => {
    console.log("Editando cliente:", client);
};


defineExpose({
    fetchClients
});


onMounted(() => {
    // Carga inicial de la página 1 con el valor inicial de perPage (10)
    fetchClients();
});
</script>

<style scoped>

</style>

