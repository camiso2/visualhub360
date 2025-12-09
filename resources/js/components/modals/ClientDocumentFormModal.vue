<template>
    <DocumentsRoot :modelValue="props.modelValue" @update:modelValue="value => emit('update:modelValue', value)"
        title="Agregar Nuevo Documento" :client-id="props.clientId">
        <form @submit.prevent="submitDocument" class="space-y-6">
            <input type="hidden" :value="props.clientId" />
            <div>
                <label for="document-files" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Archivos de Imagen (Múltiples)
                </label>
                <div
                    class="mt-1 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6 dark:border-gray-600">
                    <div class="space-y-1 text-center">
                        <div class="flex text-sm text-gray-600 dark:text-gray-400">
                            <label for="document-files"
                                class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500 dark:bg-gray-800">
                                <span>Cargar archivos</span>
                                <input id="document-files" name="document_files[]" type="file" class="sr-only"
                                    @change="handleFileUpload" accept="image/*" multiple>
                            </label>
                            <p class="pl-1">o arrastrar y soltar</p>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF hasta 5MB por archivo</p>

                        <p v-if="documentFiles.length" class="text-sm text-green-600 font-semibold mt-2">
                            {{ documentFiles.length }} archivo(s) seleccionado(s)
                        </p>UpdateDataClienteForm
                    </div>
                </div>
            </div>

            <div>
                <label for="doc-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Nombre del Documento
                </label>
                <div class="mt-1">
                    <input v-model="documentName" type="text" id="doc-name" required
                        placeholder="Ej: Certificado de Cámara de Comercio"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                </div>
            </div>

            <div>
                <label for="doc-description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Descripción (Opcional)
                </label>
                <div class="mt-1">
                    <textarea v-model="documentDescription" id="doc-description" rows="3"
                        placeholder="Breve descripción del propósito del documento."
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                </div>
            </div>
        </form>

        <template #footer>
            <button @click="emit('update:modelValue', false)" type="button"
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                Cancelar
            </button>
            <button @click="submitDocument" type="submit" :disabled="loading"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50 transition duration-150">
                <span v-if="loading">Guardando...</span>
                <span v-else>Guardar Documento</span>
            </button>
        </template>
    </DocumentsRoot>
</template>



<script setup>
import { ref } from 'vue'
import api from '@/plugins/axios'
import DocumentsRoot from './DocumentsRoot.vue'
import { useAuthStore } from '@/stores/useAuthStore'

const authStore = useAuthStore()

// Estado general
const loading = ref(false)
const error = ref(null)
const isModalOpen = ref(false)
const selectedClientId = ref(null)

// Campos del formulario
const documentName = ref('')
const documentDescription = ref('')
const documentFiles = ref([])

// Props del componente padre
const props = defineProps({
    clientId: Number
})

const emit = defineEmits(['update:modelValue', 'documentSaved'])


// -----------------------------------------
// SUBMIT FORM
// -----------------------------------------
const submitDocument = async () => {
    if (!documentName.value || !documentDescription.value || documentFiles.value.length === 0) {
        alert('Por favor, completa todos los campos y selecciona al menos una imagen.')
        return
    }

    if (!props.clientId) {
        alert('Error: No se pudo identificar el cliente.')
        console.error('client_id NULL en submit.')
        return
    }

    const formData = new FormData()
    formData.append('name_company', documentName.value)
    formData.append('description', documentDescription.value)
    formData.append('client_id', props.clientId)     // 🔥 CORREGIDO
    formData.append('company_id', authStore.user.company.id)

    // Archivos
    documentFiles.value.forEach(file => {
        formData.append('document_files[]', file)
    })

    loading.value = true

    try {
        await api.post(`/documentsClient`, formData)

        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Documento agregado con éxito!",
            showConfirmButton: false,
            timer: 1500
        })

        emit('update:modelValue', false)   // 🔥 CERRAR MODAL
        emit('documentSaved')

        documentName.value = '';
        documentDescription.value = '';
        documentFiles.value = [];

        // isModalOpen.value = false

    } catch (err) {
        loading.value = false

        const errorMessage = err.response?.data?.message || err.message || 'Error desconocido.'

        if (err.response && err.response.status === 422) {
            const validationErrors = Object.values(err.response.data.errors)
                .flat()
                .join('\n')

            alert('Fallo de validación:\n' + validationErrors)
        } else {
            alert(`Error al guardar el documento: ${errorMessage}`)
        }

        Swal.fire({
            position: "top-end",
            icon: "error",
            title: "Error al subir el documento. Inténtelo de nuevo.",
            showConfirmButton: false,
            timer: 1500
        })

    } finally {
        loading.value = false
    }
}

// -----------------------------------------
// FILE UPLOAD
// -----------------------------------------
const handleFileUpload = (event) => {
    const newFiles = event.target.files

    if (newFiles.length === 0) return

    let tempNewFiles = Array.from(newFiles)

    for (const file of tempNewFiles) {
        if (file.size > 5 * 1024 * 1024) {
            alert(`El archivo "${file.name}" supera los 5MB.`)
            event.target.value = ''
            return
        }
    }

    documentFiles.value = documentFiles.value.concat(tempNewFiles)

    // Reset input
    event.target.value = null

    console.log("Archivos acumulados:", documentFiles.value.length)
}

</script>
