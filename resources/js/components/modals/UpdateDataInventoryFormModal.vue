<template>
    <DocumentsRoot :modelValue="props.modelValue" @update:modelValue="value => emit('update:modelValue', value)"
        title=" " :inventory-id="props.inventoryId">

        <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700 ">

            <HeaderButtonGenInformComplet :title="`Actualizar Datos del Producto`" :isDopDownVisible="false">
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
                <div v-if="props.inventoryData?.image && !form.image" class="mt-2 mb-2">

                    <div @click="$openImageViewer(props.inventoryData.image || '/avatars/default-avatar.png')"
                        class="w-16 h-16 overflow-hidden rounded-md shadow-md border cursor-pointer group relative">


                        <img :src="props.inventoryData.image || '/avatars/default-avatar.png'"
                            :alt="props.inventoryData.image"
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
                </div>

                <div class="flex flex-col w-full md:w-64">
                    <label class="text-sm font-medium text-gray-700"> Identificador del Producto</label>
                    <span
                        class="bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300 px-3 py-2 text-xs font-semibold rounded-full w-fit"><b>Código
                            del Producto
                            :
                        </b>{{ inventoryData.sku }}
                    </span>

                </div>
                <hr class="mt-3 mb-3" />


                <form @submit.prevent="handleSubmit" class="flex flex-wrap items-start gap-6">
                    <div class="flex flex-wrap w-full gap-6">
                        <div class="w-full md:w-[calc(50%-12px)] lg:w-[calc(33.33%-16px)]">
                            <div class="w-full border-b border-gray-200 dark:border-gray-700 mb-4 pb-2">
                                <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200">Datos Generales</h3>
                            </div>

                            <div class="flex flex-col w-48 mb-3">
                                <label for="image_file" class="text-sm font-medium text-gray-700">
                                    Imagen del Producto *
                                </label>
                                <input type="file" id="image_file" @change="handleProductImageUpload" required class="mt-1 block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4 file:rounded-full
                file:border-0 file:text-sm file:font-semibold
                file:bg-green-50 file:text-green-700 hover:file:bg-green-100
                transition duration-150" />
                            </div>
                            <div class="flex flex-wrap w-full gap-4">
                                <div class="flex flex-col w-full">
                                    <label class="text-sm font-medium text-gray-700">Nombre *</label>
                                    <input type="text" v-model="form.name" required
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                                </div>
                                <div class="flex flex-wrap w-full gap-4 items-start">
                                    <div class="w-full sm:w-auto flex-grow">
                                        <CategoriesOptical v-model="form.category" />
                                    </div>
                                    <div class="flex flex-col w-full  md:w-[calc(50%-8px)] ">
                                        <label class="text-sm font-medium text-gray-700">Cantidad (Stock) *</label>
                                        <input type="text" v-model.number="form.quantity" maxlength="5"  @input="form.quantity = $getFormatDecimal($event.target.value)" required min="0"
                                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                                    </div>
                                    <div class="flex flex-col w-full md:w-[calc(50%-8px)] ">
                                        <label class="text-sm font-medium text-gray-700">Stock Mínimo.....</label>
                                        <input type="text" v-model.number="form.min_stock" @input="form.min_stock = $getFormatDecimal($event.target.value)" maxlength="3" min="0"
                                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                                    </div>
                                </div>
                                <div class="flex flex-col w-full">
                                    <label class="text-sm font-medium text-gray-700">Descripción</label>
                                    <textarea v-model="form.description" rows="3"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs"></textarea>
                                </div>
                                <div class="flex flex-row w-full items-center gap-6">
                                    <!-- Imagen del producto -->


                                    <!-- Checkbox Activo -->
                                    <div class="flex items-center mt-6">
                                        <input type="checkbox" v-model="form.active"
                                            class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500" />
                                        <label class="ml-2 text-sm font-medium text-gray-700">
                                            Activo
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-[calc(50%-12px)] lg:w-[calc(33.33%-16px)]">
                            <div class="w-full border-b border-gray-200 dark:border-gray-700 mb-4 pb-2">
                                <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200">Detalles de Costo y
                                    Venta
                                </h3>
                            </div>
                            <div class="flex flex-wrap w-full gap-4">
                                <div class="flex flex-col w-full md:w-[calc(50%-8px)]">
                                    <label class="text-sm font-medium text-gray-700">Prec Comp</label>
                                    <input type="text" v-model.number="form.purchase_price" @input="form.purchase_price = $getFormatDecimal($event.target.value)" maxlength="10" required min="0"
                                        step="0.01"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                                </div>
                                <div class="flex flex-col w-full md:w-[calc(50%-8px)]">
                                    <label class="text-sm font-medium text-gray-700">Imp Comp (%)</label>
                                    <input type="text" v-model.number="form.tax_purchase" @input="form.tax_purchase = $getFormatDecimal($event.target.value)" maxlength="4" min="0" step="0.01"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                                </div>
                                <div class="flex flex-col w-full md:w-[calc(50%-8px)]">
                                    <label class="text-sm font-medium text-gray-700">Prec de Venta</label>
                                    <input type="text" v-model.number="form.sale_price" @input="form.sale_price = $getFormatDecimal($event.target.value)" maxlength="10" required min="0" step="0.01"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                                </div>
                                <div class="flex flex-col w-full md:w-[calc(50%-8px)]">
                                    <label class="text-sm font-medium text-gray-700">Imp Venta (%)</label>
                                    <input type="text" v-model.number="form.tax_sale" @input="form.tax_sale = $getFormatDecimal($event.target.value)" maxlength="3" min="0" step="0.01"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                                </div>

                                <div class="flex flex-col w-full md:w-[calc(50%-8px)]">
                                    <label class="text-sm font-medium text-gray-700">Máx. Desc (%)</label>
                                    <input type="text" v-model.number="form.max_disscount" @input="form.max_disscount = $getFormatDecimal($event.target.value)" maxlength="2" min="0" max="100"
                                        step="0.01"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-full lg:w-[calc(33.33%-16px)]">
                            <div class="w-full border-b border-gray-200 dark:border-gray-700 mb-4 pt-2 pb-2 md:pt-0">
                                <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200">Archivos y
                                    Referencias
                                </h3>
                            </div>
                            <div class="flex flex-wrap w-full gap-4 items-start">
                                <div class="flex flex-col w-full">
                                    <label for="image_invoice_file" class="text-sm font-medium text-gray-700">Imagen de
                                        Factura</label>
                                    <input type="file" id="image_invoice_file" @change="handleInvoiceImageUpload" class="mt-1 block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4 file:rounded-full
                        file:border-0 file:text-sm file:font-semibold
                        file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition duration-150" />
                                </div>

                                <div class="flex flex-col w-full">
                                    <label class="text-sm font-medium text-gray-700">Número de Factura</label>
                                    <input type="text" v-model="form.number_invoice"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                                </div>
                                <div v-if="inventoryData.supplier" class="flex flex-col w-full">


                                    <label for="supplier-select"
                                        class="text-sm font-medium text-gray-700 mt-3 dark:text-gray-300">
                                        <b>Proveedor Actual</b>
                                    </label>
                                    <hr class="mt-3 mb-3">

                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500 dark:text-gray-400">Compañia :</span>
                                        <span class="font-medium"><b>{{ inventoryData.supplier.name ?
                                            inventoryData.supplier.name :
                                                'Sin proveedor' }}</b></span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500 dark:text-gray-400">Teléfono:</span>
                                        <span class="font-medium">{{ inventoryData.supplier.phone ?
                                            inventoryData.supplier.phone :
                                            'Sin proveedor' }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500 dark:text-gray-400">Dirección:</span>
                                        <span class="font-medium">{{ inventoryData.supplier.address ?
                                            inventoryData.supplier.address
                                            : 'Sin proveedor' }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500 dark:text-gray-400">Ubicación:</span>
                                        <span class="font-medium">{{ inventoryData.supplier.country ?
                                            inventoryData.supplier.country
                                            : 'Sin proveedor' }} - {{ inventoryData.supplier.city ?
                                                inventoryData.supplier.city :
                                                'Sin proveedor' }}</span>
                                    </div>


                                </div>

                                <div v-else><span
                                        class="bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300 px-3 py-1 text-xs font-semibold rounded-full w-fit">No
                                        tiene Asignado Proveedor.</span></div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>

        <template #footer>
            <div class="flex flex-col md:flex-row gap-4 mt-4">
                <button @click="emit('update:modelValue', false)" type="button" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100
        dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700
        w-full md:w-auto">
                    Cancelar
                </button>
                <button @click="handleSubmit" :disabled="loading" class="flex items-center justify-center
        py-2 px-6 border border-transparent
        rounded-lg shadow-md text-lg font-medium text-white
        bg-green-600 hover:bg-green-700 focus:outline-none
        focus:ring-2 focus:ring-offset-2 focus:ring-green-500
        disabled:opacity-50 transition duration-150
        w-full md:w-auto text-center gradient-button">

                    <svg v-if="loading" class="animate-spin mr-3 h-5 w-5 text-white" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2.01 5.938A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>

                    <svg v-else class="mr-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>

                    <span class="leading-snug whitespace-nowrap text-center">
                        {{ form.id ? (loading ? 'Actualizando Producto...' : 'Actualizar Producto') :
                            (loading ? 'Registrando Sucursal...' : 'Registrar Sucursal') }}
                    </span>
                </button>
            </div>
        </template>
    </DocumentsRoot>
</template>

<script setup>
import { reactive, ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import HeaderButtonGenInformComplet from '@/components/HeaderButtonGenInformComplet.vue';
import DepartamentoCiudadSelect from '@/components/DepartamentoCiudadSelect.vue';
import api from "@/plugins/axios";
import DocumentsRoot from './DocumentsRoot.vue'
import { useAuthStore } from '@/stores/useAuthStore'
import CategoriesOptical from '@/components/CategoriesOptical.vue';

// --- Dependencias externas o estáticas ---
// **NOTA:** Asumo que tienes una forma de cargar los roles, para el ejemplo, los defino estáticamente.

// ----------------------------------------------------------------------
// 1. PINIA & ESTADO GLOBAL
// ----------------------------------------------------------------------
const authStore = useAuthStore();

// ----------------------------------------------------------------------
// 2. PROPS y EMITS (Ajuste crucial)
// ----------------------------------------------------------------------
const props = defineProps({
    modelValue: Boolean,
    inventoryData: {
        type: Object,
        default: () => ({})
    },
    inventoryId: [Number, String, null]
});


// 🎯 Agregamos un emit para notificar al padre que la data fue actualizada.
const emit = defineEmits(['update:modelValue', 'documentSaved', "inventory-registered"])
const router = useRouter();
const supplier = ref(null)


// ----------------------------------------------------------------------
// 3. ESTADO LOCAL
// ----------------------------------------------------------------------
const loading = ref(false);
const successMessage = ref(null);
const errorMessage = ref(null);

// ----------------------------------------------------------------------
// 4. FORMULARIO REACTIVO (Alineado con el payload del usuario)
// ----------------------------------------------------------------------
const form = reactive({
    id: null,
    name: '',
    description: '',
    sku: '',
    category: '',
    supplier: null,
    branch_id: null,
    purchase_price: '',
    sale_price: '',
    net_price: '',
    quantity: '',
    min_stock: '',
    number_invoice: '',
    tax_purchase: '',
    tax_sale: '',
    max_disscount: '',
    active: true,

    image: null,          // archivo IMAGE
    image_url: '',        // URL actual de la imagen (para vista previa)

    image_invoice: null,  // archivo de factura
    invoice_url: ''       // URL actual factura
});





// ----------------------------------------------------------------------
// 5. LÓGICA DE CARGA DE DATOS DEL USUARIO (WATCHER)
// ----------------------------------------------------------------------
watch(() => props.inventoryData, (data) => {

    // Si no hay data → es nuevo registro
    if (!data || !data.id) {
        Object.assign(form, {
            id: null,
            name: '',
            description: '',
            sku: '',
            category: '',
            supplier: null,
            branch_id: null,
            purchase_price: '',
            sale_price: '',
            net_price: '',
            quantity: '',
            min_stock: '',
            number_invoice: '',
            tax_purchase: '',
            tax_sale: '',
            max_disscount: '',
            active: true,

            image: null,
            image_url: '',

            image_invoice: null,
            invoice_url: ''
        });

        console.log("Formulario limpio → nuevo inventario");
        return;
    }

    // Si hay data → llenar el formulario
    Object.assign(form, {
        id: data.id,
        name: data.name ?? '',
        description: data.description ?? '',
        sku: data.sku ?? '',
        category: data.category ?? '',
        //supplier: data.supplier_id ?? data.supplier?.id ?? data.supplier_info?.id ?? null,
        supplier_id: data.supplier_id ?? null,
        branch_id: data.branch_id ?? null,
        purchase_price: data.purchase_price ?? '',
        sale_price: data.sale_price ?? '',
        net_price: data.net_price ?? '',
        quantity: data.quantity ?? '',
        min_stock: data.min_stock ?? '',
        number_invoice: data.number_invoice ?? '',
        tax_purchase: data.tax_purchase ?? '',
        tax_sale: data.tax_sale ?? '',
        max_disscount: data.max_disscount ?? '',
        active: !!data.active,

        // NO se llena con File → esto es SOLO URL
        image: null,
        image_url: data.image ?? '',

        image_invoice: null,
        invoice_url: data.image_invoice ?? ''
    });
    console.log("Formulario cargado → inventario ID:", data.active ?? null);

}, { immediate: true });

watch(() => props.modelValue, (isOpen) => {
    if (isOpen) {
        // El modal se abrió → limpiar mensajes
        successMessage.value = null;
        errorMessage.value = null;
    }
});

// ----------------------------------------------------------------------
// 6. MANEJADORES DE EVENTOS Y SUBMIT
// ----------------------------------------------------------------------

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;
        imagePreview.value = URL.createObjectURL(file);

    }
};

const handleSubmit = async () => {
    authStore.loading = true; // Activa el Global Loader
    loading.value = true;
    errorMessage.value = null;
    successMessage.value = null;

    // 1. Determinar el método y el endpoint
    const isUpdate = !!form.id;
    /* let endpoint = isUpdate ? `/admin/inventoryes/${form.id}` : '/admin/inventoryes/'; // Ajusta el endpoint de creación si es diferente
     let httpMethod = isUpdate ? 'post' : 'post'; // Se usa POST con FormData/multipart*/

    // 2. Preparar FormData
    const formDataPayload = new FormData();

    console.log('formDataPayload ::', formDataPayload)

    for (const key in form) {
        const value = form[key];

        // Excluir campos no necesarios o vacíos, o ajustar el valor para el backend
        if (key === 'supplier_id') continue; // ID es parte del endpoint,

        // Si el valor es null/undefined, envíalo como string vacío o ajusta a tu backend
        const finalValue = value instanceof File ? value : (value === null || value === undefined ? '' : value);
        formDataPayload.append(key, finalValue);
    }




    try {
        // 3. Enviar la petición
        const response = await api.post(`/admin/inventories/${form.id}`, formDataPayload);

        // 4. Manejo de éxito
        successMessage.value = response.data.message ?? (isUpdate ? 'Usuario actualizado exitosamente.' : 'Usuario registrado exitosamente.');

        // Notificación de éxito
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: isUpdate ? "Usuario Actualizado con éxito!" : "Usuario Registrado con éxito!",
            showConfirmButton: false,
            timer: 1500
        });

        // 5. Emitir evento de actualización/registro
        emit("dataUpdated", {
            success: true,
            inventoryId: response.data.inventory?.id ?? form.id,
            data: response.data.inventory
        });

        // Cierra el modal después de la operación exitosa
        emit('update:modelValue', false);

    } catch (error) {
        // 6. Manejo de error
        console.error("Error en la operación de usuario:", error);
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
    } finally {
        // 7. Desactivar el Global Loader
        loading.value = false;
        authStore.loading = false;
    }
};

const handleProductImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;

        // 🔑 CORRECCIÓN: Usar form.image_url para la vista previa
        form.image_url = URL.createObjectURL(file);
    }
};
</script>


<style scoped>
/* Las clases de estilo proporcionadas no son necesarias para la funcionalidad,
   pero se mantienen si solucionan problemas de layout en otros lugares. */
</style>
