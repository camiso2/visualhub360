<template>
    <div class="m-0 p-0 w-full upper-all">
        <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">

            <HeaderButtonGenInformComplet :title="`Lista de Colaboradores`" :isDopDownVisible=true>
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 3a.75.75 0 00-.75.75V1.5h-1.5a.75.75 0 00-.75.75V3H9.75V1.5a.75.75 0 00-.75-.75H7.5a.75.75 0 00-.75.75V3H6.75A.75.75 0 006 3.75v16.5c0 .414.336.75.75.75h10.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75H15.75zM12 12h.008v.008H12V12zM12 16h.008v.008H12V16zM15.75 8.25V6.75a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0zM8.25 8.25V6.75a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0z" />
                    </svg>
                </template>
            </HeaderButtonGenInformComplet>


            <div class="flex w-full items-center space-x-2 mt-2">


                <input v-model="searchTerm" @keyup.enter="handleSearch"
                    placeholder="Buscar colaborador (nombre, doc, email, tel)..." class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-blue-500 focus:border-blue-500
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
                    Total de Colaboradores: <b>{{ totalUsers }}</b>
                </div>

                <div class="flex items-center space-x-2 ml-auto pr-4 pt-1 pb-1 md-w-full">
                    <select v-model="selectedRoleName" @change="handleSearch" class="bg-neutral-secondary-medium  border border-default-medium text-heading text-sm rounded-base focus:ring-blue-500 focus:border-blue-500
                   block px-3 py-2 shadow-xs placeholder:text-body w-full md:w-auto">
                        <option v-for="role in availableRoles" :key="role.value" :value="role.value">
                            {{ role.name }}
                        </option>
                    </select>
                </div>

                <div class="flex items-center space-x-2 mt-2 md:mt-0 mr-1">
                    <label for="perPageSelect" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Mostrar
                    </label>
                    <select id="perPageSelect" v-model="perPage" @change="fetchUsers(1, searchTerm, perPage)"
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
            Cargando usuarios...
        </div>
        <div v-else-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
            role="alert">
            Error al cargar los usuarios: {{ error }}
        </div>
        <div v-else-if="usersData.length === 0"
            class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
            No se encontraron usuarios en la compañía.
        </div>

        <div v-else class="m-0 p-0 space-y-0 text-gray-600 dark:text-gray-300">
            <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <div
                    class="bg-white mt-4 dark:bg-gray-900 h-[52rem] overflow-y-auto border border-gray-200 dark:border-gray-700 relative">
                    <div
                        class="hidden md:grid grid-cols-11 px-5 py-3 bg-gray-50 dark:bg-gray-800
            text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide border-b border-gray-100 dark:border-gray-700">

                        <div class="flex items-center space-x-0">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A9 9 0 1119 12.5a4 4 0 01-8 0 4 4 0 118 0" />
                            </svg>
                            <span>Avatar</span>
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
                            <span>Documento</span>
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
                                    d="M12 14l9-5-9-5-9 5 9 5zM12 14v7m0-7L3 9l9 5zM12 14l9-5v7" />
                            </svg>
                            <span>Rol</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Permisos</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v4a1 1 0 001 1h16a1 1 0 001-1V7M3 11l9 6 9-6" />
                            </svg>
                            <span>Cargo</span>
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
                                    d="M11 4h2m7.121 2.879l-2 2L9 17l-4 1 1-4 9.121-9.121a2 2 0 112.828 2.828z" />
                            </svg>
                            <span>Acciones</span>
                        </div>


                    </div>



                    <div v-for="user in usersData" :key="user.id" class="grid grid-cols-1 md:grid-cols-11 px-5 py-4 text-sm border-b border-gray-100 dark:border-gray-700
                        hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-150">

                        <!-- <div class="flex items-center">
                            <img :src="user.avatar || '/avatars/default-avatar.png'" alt="Avatar"
                                class="w-12 h-12 rounded-full object-cover" />
                        </div>-->

                        <div @click="$openImageViewer(user.avatar || '/avatars/default-avatar.png')"
                            class="w-12 h-12 overflow-hidden rounded-md shadow-md border cursor-pointer group relative">

                            <img :src="user.avatar || '/avatars/default-avatar.png'" :alt="user.avatar"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" />


                                <p>Colombia</p>



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
                            <span class="md:hidden text-gray-400 text-xs font-semibold ">Nombre&nbsp;&nbsp;</span>
                            <span class="font-medium"><b>{{ user.name }}</b></span>
                        </div>

                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Documento&nbsp;&nbsp;</span>
                            <span>{{ user.document_type }} {{ user.document_number }}</span>
                        </div>

                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Email&nbsp;&nbsp;</span>
                            <span class="text-blue-700 dark:text-blue-400">{{ user.email }}</span>
                        </div>

                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Teléfono&nbsp;&nbsp;</span>
                            <span>{{ user.phone }}</span>
                        </div>
                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Dirección&nbsp;&nbsp;</span>
                            <span>{{ user.address }}<br>{{ user.city }} - {{ user.department }}</span>
                        </div>



                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Rol&nbsp;&nbsp;</span>
                            <span>{{ user.roles?.[0]?.name || 'Sin rol' }}</span>
                        </div>

                        <div class="relative">
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Permisos&nbsp;&nbsp;</span>

                            <div v-if="user.roles && user.roles.length" class="w-full max-w-xs relative">
                                <button @click="toggleDropdown(user.id)"
                                    class="w-full cursor-pointer rounded-md bg-white py-1.5 pl-3 pr-10 text-left shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 sm:text-sm">
                                    <span class="block truncate text-gray-700">
                                        {{ selectedPermissions[user.id]?.name || 'Ver permisos' }}
                                    </span>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </button>

                                <div v-if="showDropdown === user.id"
                                    class="absolute z-50 mt-1 w-full max-h-20 overflow-auto rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5">
                                    <div v-for="permission in user.roles.flatMap(r => r.permissions)"
                                        :key="permission.id" @click="selectPermission(user.id, permission)"
                                        class="relative cursor-pointer select-none py-2 pl-10 pr-4 text-gray-700 hover:bg-indigo-100">
                                        <span class="block truncate">{{ permission.name }}</span>
                                        <span v-if="selectedPermissions[user.id]?.id === permission.id"
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 text-indigo-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <span v-else class="text-xs text-gray-400">Sin permisos asignados</span>
                        </div>

                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Cargo&nbsp;&nbsp;</span>
                            <span>{{ user.roles[0]?.description || 'sin cargo asignado' }}</span>
                        </div>

                        <div>
                            <span class="md:hidden text-gray-400 text-xs font-semibold">Estado&nbsp;&nbsp;</span>
                            <span :class="user.active
                                ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'
                                : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300'"
                                class="px-3 py-1 text-xs font-semibold rounded-full w-fit">
                                {{ user.active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>

                        <div class="flex flex-col mt-0 md:flex-row items-center gap-2 mt-0 md:mt-0 w-full">
                            <div class="w-full">
                                <button @click="openUpdateModal(user)" :disabled="loading" class="flex items-center justify-center space-x-2 bg-yellow-500 hover:bg-yellow-600 text-white
        px-4 h-9 rounded-lg text-sm font-medium transition-all shadow-md
        hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-yellow-400
        focus:ring-offset-1 w-full">
                                    <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 4h2m7.121 2.879l-2 2L9 17l-4 1 1-4 9.121-9.121a2 2 0 112.828 2.828z" />
                                    </svg>
                                    <span class="leading-snug whitespace-nowrap text-center">
                                        {{ loading ? 'Editar Colaborador...' : 'Editar Colaborador' }}
                                    </span>
                                </button>
                            </div>
                        </div>

                    </div>


                    <div v-if="totalUsers > 0"
                        class="h-16 w-full flex items-center justify-between px-4 text-sm font-medium border-t border-gray-200 bg-white shadow-inner">

                        <div class="text-gray-500">
                            Mostrando
                            <span class="font-bold">{{ (currentPage - 1) * perPage + 1 }}</span>
                            a
                            <span class="font-bold">{{ Math.min(currentPage * perPage, totalUsers) }}</span>
                            de
                            <span class="font-bold">{{ totalUsers }}</span> colaboradores.
                        </div>

                        <div v-if="totalPages > 1" class="inline-flex rounded-md shadow-sm -space-x-px" role="group">

                            <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1 || loading" class="px-3 py-1.5 text-gray-700
                border border-gray-300 rounded-l-md
                hover:bg-gray-50 disabled:bg-white disabled:opacity-50 disabled:cursor-not-allowed
                transition-colors duration-150">
                                Anterior
                            </button>

                            <!-- <button v-for="page in visiblePages" :key="page" @click="goToPage(page)" :disabled="loading"
                                class="px-3 py-1.5 text-sm font-medium transition-colors duration-150 border border-gray-300"
                                :class="{
                                    // Usamos la clase 'z-10' para asegurar que el botón activo se vea correctamente
                                    'z-10 bg-blue-50 text-blue-700 border-blue-200': page === currentPage,
                                    'bg-white text-gray-700 hover:bg-gray-50': page !== currentPage
                                }">
                                {{ page }}
                            </button>-->

                            <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages || loading"
                                class="px-3 py-1.5 text-gray-700
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

        <UpdateDataUserFormModal v-model="isUpdateModalOpen" :user-data="selectedUser" :available-roles="availableRoles"
            @dataUpdated="handleDataUpdated" />
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch, computed } from 'vue'
import api from '@/plugins/axios';
import HeaderButtonGenInformComplet from '../components/HeaderButtonGenInformComplet.vue'
import UpdateDataUserFormModal from '@/components/modals/UpdateDataUserFormModal.vue';


import { useAuthStore } from '@/stores/useAuthStore'
const authStore = useAuthStore()
const isUpdateModalOpen = ref(false)
const selectedUser = ref(null)

const openUpdateModal = (userObject) => {
    selectedUser.value = userObject;
    // selectedClient.value = clientObject;
    isUpdateModalOpen.value = true;// Abre solo el modal de actualización

    console.log('Abriendo modal de Actualización para ID:', userObject);
}
const closeUpdateModal = () => {
    isUpdateModalOpen.value = false
    selectedUser.value = null
}
const handleDataUpdated = () => {
    isUpdateModalOpen.value = false; //
    // selectedClient.value = clientObject;
    selectedUser.value = null;

    console.log('Datos del cliente actualizados. Recargando lista...');
    // Cuando los datos cambian, recarga la lista para reflejar los cambios
    fetchUsers();
    // También podrías considerar cerrar el modal si el modal hijo no lo hace:
    // isUpdateModalOpen.value = false;
}



// --- ESTADO Y DATOS ---
const allUsers = ref([]) // Se cambia allUsers por la convención de datos del backend
const loading = ref(true)
const error = ref(null)

const selectedRoleName = ref('');
const availableRoles = ref([]);
// --- LÓGICA DE BÚSQUEDA ---
const searchTerm = ref(''); // Variable para el input de búsqueda

// --- ESTADO DE PAGINACIÓN DEL BACKEND ---
const usersData = ref([]) // Datos de usuarios de la página actual
const currentPage = ref(1) // Página actual (del backend)
const totalPages = ref(1) // Total de páginas (del backend)
const totalUsers = ref(0) // Total de registros (del backend)
const perPage = ref(8) // Elementos por página (del backend, lo inicializamos en 10, pero se actualizará)

// -----------------------------

// Dropdown por usuario (Lógica original, sin modificar)
const selectedPermissions = ref({})
const showDropdown = ref(null)

function toggleDropdown(userId) {
    showDropdown.value = showDropdown.value === userId ? null : userId
}

function selectPermission(userId, permission) {
    selectedPermissions.value[userId] = permission
    showDropdown.value = null
}

// Cerrar al hacer clic fuera (Lógica original, sin modificar)
function handleClickOutside(event) {
    const dropdowns = document.querySelectorAll('.relative')
    let clickedInside = false
    dropdowns.forEach(el => {
        if (el.contains(event.target)) clickedInside = true
    })
    if (!clickedInside) showDropdown.value = null
}


onBeforeUnmount(() => window.removeEventListener('click', handleClickOutside))

// --- NUEVA FUNCIÓN DE CARGA QUE RECIBE PARÁMETROS ---
const fetchUsers = async (page = currentPage.value, search = searchTerm.value, itemsPerPage = perPage.value, roleName = selectedRoleName.value) => {
    loading.value = true
    error.value = null


    console.log('roleName__ ' + roleName)

    const params = {
        page: page,
        per_page: itemsPerPage,
        search: search,
        role_name: roleName,
    };

    try {
        const response = await api.get('/users', { params })
        const responseData = response.data;

        console.log('datos recibidos ::', responseData)

        // 2. PROCESAR ROLES DISPONIBLES (available_roles) 🎯
        if (responseData.data.available_roles) {
            const rolesFromApi = responseData.data.available_roles;

            // Mapeamos los roles de la API al formato { name: '...', value: '...' }
            // Asumo que la API devuelve objetos con la propiedad 'name'.
            const mappedRoles = rolesFromApi.map(role => ({
                name: role.name,
                value: role.name // Usamos el nombre del rol como el valor para el filtro
            }));

            // Agregamos la opción "Todos" al principio del array y actualizamos la ref.
            availableRoles.value = [{ name: 'Todos', value: '' }, ...mappedRoles];

        } else {
            // Si no vienen roles, aseguramos que al menos esté la opción "Todos"
            availableRoles.value = [{ name: 'Todos', value: '' }];
        }

        // ** PARSEO DE LA RESPUESTA CON OBJETO PAGINADOR **
        // responseData -> { data: { users: { ... paginador ... } } }
        if (responseData && responseData.data && responseData.data.users) {
            const paginator = responseData.data.users;

            // 1. Extraer los datos de la página actual
            usersData.value = paginator.data || [];

            // 2. Extraer los metadatos de paginación
            currentPage.value = paginator.current_page || 1;
            totalPages.value = paginator.last_page || 1;
            totalUsers.value = paginator.total || 0;
            perPage.value = paginator.per_page || 10;
        } else {
            // Manejo de respuesta inesperada
            usersData.value = [];
            totalUsers.value = 0;
            totalPages.value = 1;
        }

        /*  Swal.fire({
              position: "top-end",
              icon: "success",
              title: "Colaboradores de la empresa obtenidos con éxito !",
              showConfirmButton: false,
              timer: 1500
          });*/

    } catch (err) {
        error.value = err.message || 'Error desconocido'
        usersData.value = [];
        totalUsers.value = 0;
        totalPages.value = 1;
    } finally {
        loading.value = false
    }
}

// --- LÓGICA DE PAGINACIÓN ADAPTADA AL BACKEND ---
// Esta función ahora llama a la API con la nueva página.
function goToPage(page) {
    if (page > 0 && page <= totalPages.value && page !== currentPage.value) {
        fetchUsers(page, searchTerm.value, perPage.value);
    }
}

// --- MANEJADOR DE BÚSQUEDA ---
function handleSearch() {
    // Cuando se busca, siempre volvemos a la página 1
    fetchUsers(1, searchTerm.value, perPage.value, selectedRoleName.value);
}

// Lógica de edición sin modificar
function editUser(user) {
    console.log('Editar usuario:', user)
}

defineExpose({
    fetchUsers // Exportamos fetchUsers, aunque ahora usa argumentos
});

onMounted(() => {
    window.addEventListener('click', handleClickOutside)
    fetchUsers()
})

// Lógica para generar los números de página visibles (basada en el ejemplo de paginación)
const visiblePages = computed(() => {
    const pages = []
    const limit = totalPages.value; // Usamos el total real del backend

    // Muestra hasta 5 botones de paginación
    let startPage = Math.max(1, currentPage.value - 2);
    let endPage = Math.min(totalPages.value, currentPage.value + 2);

    if (startPage === 1 && endPage < limit) {
        endPage = Math.min(limit, endPage + (3 - (currentPage.value - 1)));
    }
    if (endPage === limit && startPage > 1) {
        startPage = Math.max(1, startPage - (3 - (totalPages.value - currentPage.value)));
    }

    for (let i = startPage; i <= endPage; i++) {
        pages.push(i);
    }
    return pages
})
</script>
