<template>
    <div class="p-1 bg-gray-50 min-h-screen">
        <div v-if="isLoading" class="text-center py-12 text-blue-500 font-medium">
            <svg class="animate-spin h-6 w-6 mr-3 inline" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2.01 5.938A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            Cargando historial de documentos...
        </div>
        <div v-else-if="error" class="p-4 bg-red-100 border-l-4 border-red-500 text-red-700 font-medium rounded-md">
            🚨 Error al cargar: **{{ error }}**
        </div>
        <div v-else-if="documents.length" class="space-y-6">
            <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">

                <HeaderButtonGenInformComplet :title="`Lista Documentos`" :isDopDownVisible = true>
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8.25v-2.5m0 0c0-.69-.56-1.25-1.25-1.25H6.25A1.25 1.25 0 005 4.75v14.5c0 .69.56 1.25 1.25 1.25h4.5c.69 0 1.25-.56 1.25-1.25v-2.5m0-12.5h3.5c.69 0 1.25.56 1.25 1.25v3.5m-4.75 7.25h6.5c.69 0 1.25-.56 1.25-1.25V9.75L15.5 6H12m0 8.25H9.75m2.25 3H9.75" />
                    </svg>

                </template>
            </HeaderButtonGenInformComplet>
                <BackPag />
                <div v-for="document in documents" :key="document.id"
                    class="bg-white shadow-lg rounded-xl p-5 border border-gray-100 transition duration-200 hover:shadow-xl">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-start">
                        <div>
                            <h2 class="text-sm font-semibold text-gray-800 mb-1">
                                Cliente : {{ document.client_data.name || 'Documento sin Nombre' }}
                            </h2>
                            <p class="text-gray-500 text-xs">
                                <br>
                                {{ document.client_data.phone }} <br>
                                {{ document.client_data.email }} <br>
                                {{ document.client_data.address }}<br>
                                {{ document.client_data.city }}
                            </p>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-gray-800 mb-1">
                                Emisor : {{ document.name_company || 'Documento sin Nombre' }}
                            </h2>
                            <p class="text-gray-500 text-xs text-gray-600 border-l-2 border-blue-400 pl-2 ">
                                <b>Descripción :</b> {{ document.description || 'Sin descripción.' }}
                            </p>
                        </div>
                        <div>
                            <div class="space-y-1 text-sm">
                                <div v-if="document.user">
                                    <p class="text-gray-700">
                                        <span class="font-medium">Registrado por:</span>
                                        {{ document.user.name }}
                                    </p>
                                    <p class="text-gray-700">
                                        <span class="font-medium">Registrado el:</span>
                                        {{ new Date(document.created_at).toLocaleDateString('es-CO', {
                                            year: 'numeric', month: '2-digit', day: '2-digit',
                                            hour: '2-digit', minute: '2-digit'
                                        }) }}
                                    </p>
                                    <p class="text-gray-500 text-xs">
                                        Sucursal: **{{ document.branch?.name || 'N/A' }}**<br>
                                        Contacto: **{{ document.branch?.phone || 'N/A' }}*
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div v-if="document.related_images && document.related_images.length > 0">
                            <h3 class="font-medium text-gray-800 mb-2">Imágenes Adjuntas ({{
                                document.related_images.length
                                }})</h3>
                            <div class="flex flex-wrap gap-2">
                                <div v-for="image in document.related_images" :key="image.id"
                                    @click="openImageViewer(image.image)"
                                    class="w-16 h-16 overflow-hidden rounded-md shadow-md border cursor-pointer group relative">
                                    <img :src="`/${image.image}`" :alt="document.name_company"
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-gray-400 text-sm italic">No hay imágenes adjuntas.</div>
                        <div class="flex flex-col md:flex-row items-center gap-2 mt-0 md:mt-0 w-full">
                            <div class="w-full">
                                <button @click="openModalDocumentsClient(client.id)" :disabled="loading" class="flex items-center justify-center space-x-2 bg-yellow-500 hover:bg-yellow-600 text-white
        px-4 h-9 rounded-lg text-sm font-medium transition-all shadow-md
        hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-yellow-400
        focus:ring-offset-1 w-full">
                                    <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 4h2m7.121 2.879l-2 2L9 17l-4 1 1-4 9.121-9.121a2 2 0 112.828 2.828z" />
                                    </svg>
                                    <span class="leading-snug whitespace-nowrap text-center">
                                        {{ loading ? 'Editar Documento...' : 'Editar Doc Cliente' }}
                                    </span>
                                </button>
                            </div>
                            <div class="w-full">
                                <button @click="openModalDocumentsClient(client.id)" :disabled="loading" class="flex items-center justify-center space-x-2 bg-red-700 hover:bg-red-600 text-white
        px-4 h-9 rounded-lg text-sm font-medium transition-all shadow-md
        hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-400
        focus:ring-offset-1 w-full">
                                    <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span class="leading-snug whitespace-nowrap text-center">
                                        {{ loading ? 'Eliminar Documento...' : 'Eliminar Documento' }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div v-else class="p-6 text-center text-gray-500 bg-white shadow rounded-lg">
            <svg class="w-10 h-10 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                </path>
            </svg>
            <p class="font-semibold text-lg">Historial Vacío</p>
            <p>No hay documentos disponibles para el ID {{ route.params.id }}.</p>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import api from '@/plugins/axios';
import { useAuthStore } from '@/stores/useAuthStore'
import HeaderButtonGenInformComplet from '../components/HeaderButtonGenInformComplet.vue'
import BackPag from '../components/BackPag.vue';

const route = useRoute();

const documents = ref([]);
const isLoading = ref(false);
const error = ref(null);

const loading = ref(false);

// PARA EL CLIC EN LA IMAGEN
const openImageViewer = (imageUrl) => {
    console.log('imageUrl : ' + imageUrl);
    // Abre la imagen en una nueva pestaña (asumiendo que /storage/ es accesible públicamente)
    window.open(`/${imageUrl}`, '_blank');
};




const fetchClientDocuments = async () => {

    loading.value = true;
    const clientId = route.params.id;

    if (!clientId) {
        error.value = 'Error: ID del cliente no encontrado en la ruta.';
        isLoading.value = false;
        return;
    }

    isLoading.value = true;
    error.value = null;

    try {
        const response = await api.get(`/documentsClient/${clientId}/history`);

        // OPTIMIZACIÓN: Verificamos si la respuesta tiene la clave 'data' y si es un array.
        // Si no la tiene, asumimos que 'response.data' es el array.
        const data = response.data.data.documents;

        if (Array.isArray(data)) {
            documents.value = data;
        } else if (Array.isArray(response.data)) {
            documents.value = response.data;
        } else {
            // Esto ocurre si la API devolvió un objeto y no un array de documentos.
            documents.value = [];
            console.warn('API devolvió un objeto, no un array de documentos:', response.data);
        }

        console.log('documentos encontrados : ', data)
        loading.value = false;

    } catch (err) {
        console.error('Fallo la carga de documentos:', err);
        if (err.response) {
            error.value = `Error ${err.response.status}: ${err.response.data.message || 'Error del servidor.'}`;
        } else {
            error.value = 'Error de conexión o de red.';
        }
    } finally {
        isLoading.value = false;
        loading.value = false;
    }
};

onMounted(() => {
    fetchClientDocuments();
});
</script>
