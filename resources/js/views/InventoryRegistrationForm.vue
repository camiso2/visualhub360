<template>
    <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700 ">



        <HeaderButtonGenInformComplet :title="`Registrar Producto`" :isDopDownVisible=false>
            <template #icon>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8.25v-2.5m0 0c0-.69-.56-1.25-1.25-1.25H6.25A1.25 1.25 0 005 4.75v14.5c0 .69.56 1.25 1.25 1.25h4.5c.69 0 1.25-.56 1.25-1.25v-2.5m0-12.5h3.5c.69 0 1.25.56 1.25 1.25v3.5m-4.75 7.25h6.5c.69 0 1.25-.56 1.25-1.25V9.75L15.5 6H12m0 8.25H9.75m2.25 3H9.75" />
                </svg>

            </template>
        </HeaderButtonGenInformComplet>

        <div v-if="errorMessage" class="w-full bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded text-sm">
            <p class="font-semibold">Error:</p>
            <p>{{ errorMessage }}</p>
        </div>

        <div v-if="successMessage" class="w-full mt-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ successMessage }}
        </div>

        <div class="w-full overflow-x-auto bg-white rounded-xl p-3 border mb-5">

            <div class="mb-6 p-4 border rounded-lg bg-indigo-50  space-y-4">
                <form @submit.prevent="handleSubmit" class="flex flex-wrap items-start gap-6">
                    <div class="flex flex-wrap w-full gap-6">
                        <div class="w-full md:w-[calc(50%-12px)] lg:w-[calc(33.33%-16px)]">
                            <div class="w-full border-b border-gray-200 dark:border-gray-700 mb-4 pb-2">
                                <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200">Datos Generales</h3>
                            </div>
                            <div class="flex flex-row w-full items-center gap-6 mb-4">
                                <!-- Imagen del producto -->
                                <div class="flex flex-col w-4/5">
                                    <label for="image_file" class="text-sm font-medium text-gray-700">
                                        Imagen del Producto *
                                    </label>
                                    <input type="file" id="image_file" @change="handleProductImageUpload" required
                                        class="mt-1 block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4 file:rounded-full
                file:border-0 file:text-sm file:font-semibold
                file:bg-green-50 file:text-green-700 hover:file:bg-green-100
                transition duration-150" />
                                </div>

                                <!-- Checkbox Activo -->
                                <div class="flex items-center mt-6">
                                    <input type="checkbox" v-model="form.active"
                                        class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500" />
                                    <label class="ml-2 text-sm font-medium text-gray-700">
                                        Activo
                                    </label>
                                </div>
                            </div>
                            <div class="flex flex-wrap w-full gap-4">
                                <div class="flex flex-col w-full">
                                    <label class="text-sm font-medium text-gray-700">Nombre *</label>
                                    <input type="text" v-model="form.name" required
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                                </div>
                                <div class="flex flex-wrap w-full gap-4 items-start">
                                    <div class="w-full sm:w-24 flex-grow">
                                        <CategoriesOptical v-model="form.category" />
                                    </div>
                                    <div class="flex flex-col w-full sm:w-24 md:w-24 lg:w-24 **ml-auto**">
                                        <label class="text-sm font-medium text-gray-700">Cant (Stock) *</label>
                                        <input type="text" v-model.number="form.quantity"
                                            @input="form.quantity = $getFormatDecimal($event.target.value)" required
                                            min="0"
                                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                                    </div>
                                    <div class="flex flex-col w-full sm:w-24 md:w-24 lg:w-24">
                                        <label class="text-sm font-medium text-gray-700">Stock Mínimo</label>
                                        <input type="number" v-model.number="form.min_stock"
                                            @input="form.min_stock = $getFormatDecimal($event.target.value)" min="0"
                                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                                    </div>
                                </div>
                                <div class="flex flex-col w-full">
                                    <label class="text-sm font-medium text-gray-700">Descripción</label>
                                    <textarea v-model="form.description" rows="3"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs"></textarea>
                                </div>

                            </div>
                        </div>
                        <div class="w-full md:w-[calc(50%-12px)] lg:w-[calc(66.33%-16px)]">
                            <div class="w-full border-b border-gray-200 dark:border-gray-700 mb-4 pb-2">
                                <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200">Detalles de Costo y
                                    Venta
                                </h3>
                            </div>
                            <div class="flex flex-wrap w-full gap-4">
                                <div class="flex flex-col w-full md:w-[calc(18%-8px)]">
                                    <label class="text-sm font-medium text-gray-700">Precio de Compra *</label>
                                    <input type="text" v-model.number="form.purchase_price"
                                        @input="form.purchase_price = $getFormatDecimal($event.target.value)" required
                                        min="0" step="0.01"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                                </div>
                                <div class="flex flex-col w-full md:w-[calc(18%-8px)]">
                                    <label class="text-sm font-medium text-gray-700">Impuesto Compra (%)</label>
                                    <input type="text" v-model.number="form.tax_purchase"
                                        @input="form.tax_purchase = $getFormatDecimal($event.target.value)" min="0"
                                        step="0.01"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                                </div>
                                <div class="flex flex-col w-full md:w-[calc(18%-8px)]">
                                    <label class="text-sm font-medium text-gray-700">Precio de Venta *</label>
                                    <input type="text" v-model.number="form.sale_price"
                                        @input="form.sale_price = $getFormatDecimal($event.target.value)" required
                                        min="0" step="0.01"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                                </div>
                                <div class="flex flex-col w-full md:w-[calc(18%-8px)]">
                                    <label class="text-sm font-medium text-gray-700">Impuesto Venta (%)</label>
                                    <input type="text" v-model.number="form.tax_sale"
                                        @input="form.tax_sale = $getFormatDecimal($event.target.value)" min="0"
                                        step="0.01"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                                </div>

                                <div class="flex flex-col w-full md:w-[calc(18%-8px)]">
                                    <label class="text-sm font-medium text-gray-700">Máx. Descuento (%)</label>
                                    <input type="text" v-model.number="form.max_disscount"
                                        @input="form.max_disscount = $getFormatDecimal($event.target.value)" min="0"
                                        max="100" step="0.01"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                                </div>
                            </div>
                            <div class="w-full md:w-full lg:w-[calc(66.33%-16px)] mt-5">
                            <div class="w-full border-b border-gray-200 dark:border-gray-700 mb-4 pt-2 pb-2 md:pt-0">
                                <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200">Archivos y
                                    Referencias
                                </h3>
                            </div>
                            <div class="flex flex-wrap w-full gap-4 items-start">
                                <div class="flex flex-col w-full md:w-[calc(37%-8px)]">
                                    <label for="image_invoice_file" class="text-sm font-medium text-gray-700">Imagen de
                                        Factura</label>
                                    <input type="file" id="image_invoice_file" @change="handleInvoiceImageUpload" class="mt-1 block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4 file:rounded-full
                        file:border-0 file:text-sm file:font-semibold
                        file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition duration-150" />
                                </div>

                                <div class="flex flex-col w-full md:w-[calc(30%-8px)]">
                                    <label class="text-sm font-medium text-gray-700">Número de Factura</label>
                                    <input type="text" v-model="form.number_invoice"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs" />
                                </div>
                                <div class="flex flex-col w-full md:w-[calc(30%-8px)]">
                                    <label for="supplier-select" class="text-sm font-medium text-gray-700">Seleccionar
                                        Proveedor</label>
                                    <select id="supplier-select" v-model="form.supplier_id"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs">
                                        <option :value="null" disabled>-- Selecciona un proveedor --</option>

                                        <option v-for="supplier in suppliersData" :key="supplier.id"
                                            :value="supplier.id">
                                            {{ supplier.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        </div>

                    </div>
                    <div class="w-full border-t border-gray-200 dark:border-gray-700 mt-2 pt-4 flex justify-end">
                        <div class="flex items-end w-full md:w-auto">
                            <button type="submit" :disabled="loading" class="flex items-center justify-center
                py-3 px-6 border border-transparent
                rounded-lg shadow-md text-lg font-medium text-white
                bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 transition duration-150
                w-full md:w-auto text-center gradient-button">

                                <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
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

                                <span>{{ loading ? 'Registrando Producto...' : 'Registrar Producto' }}</span>

                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <InventoriesView ref="InventoriesViewRef" />
    </div>
</template>


<script setup>
import { reactive, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/useAuthStore';
import HeaderButtonGenInformComplet from '../components/HeaderButtonGenInformComplet.vue';
import CategoriesOptical from '../components/CategoriesOptical.vue';
import InventoriesView from './InventoriesView.vue';
import api from "@/plugins/axios";

const router = useRouter();
const authStore = useAuthStore();



const successMessage = ref(null);
const loading = ref(false);
const errorMessage = ref(null);

// FORMULARIO PRINCIPAL ADAPTADO PARA PRODUCTOS
const form = reactive({
    name: '',           // * string
    category: '',       // string
    description: '',    // string
    quantity: 0,        // * integer
    min_stock: 0,       // integer
    purchase_price: 0,  // * number($float)
    tax_purchase: 0,    // number($float)
    sale_price: 0,      // * number($float)
    tax_sale: 0,        // number($float)
    max_disscount: 0,   // number($float)
    number_invoice: '', // string
    supplier_id: null,  // integer
    image: null,        // * string($binary)
    image_invoice: null,// string($binary)
    branch_id: authStore.user.branch_id, // SETEADO CORRECTAMENTE
    active: true,       // boolean
});

// MANEJO DE ARCHIVO: Imagen del Producto
const handleProductImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;
    }
};

// MANEJO DE ARCHIVO: Imagen de Factura
const handleInvoiceImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image_invoice = file;
    }
};

const InventoriesViewRef = ref(null);

// SUBMIT
const handleSubmit = async () => {
    loading.value = true;
    errorMessage.value = null;
    successMessage.value = null;
    authStore.loading = true;

    const token = authStore.token;

    if (!token) {
        errorMessage.value = 'No se encontró el token de autenticación.';
        loading.value = false;
        authStore.loading = false;
        return;
    }

    const formData = new FormData();
    for (const key in form) {
        const value = form[key];

        // Manejo especial para archivos
        if (key === 'image' || key === 'image_invoice') {
            if (value instanceof File) {
                formData.append(key, value);
            } else if (key === 'image' && !value) {
                // Si la imagen principal es requerida y está vacía, puedes agregar un chequeo aquí
            }
        }
        // Conversión a string para valores booleanos y nulos para FormData (si es necesario)
        else if (typeof value === 'boolean') {
            formData.append(key, value ? '1' : '0');
        }
        else {
            // Envía el valor o un string vacío si es null/undefined
            formData.append(key, value ?? '');
        }
    }

    try {

        const response = await api.post('/admin/inventories', formData);
        console.log('Cliente registrado', response.data);

        successMessage.value = response.data.message ?? 'Producto registrado exitosamente.';

        console.log('recibe lo siguien', response.data)

        if (InventoriesViewRef.value) {
            InventoriesViewRef.value.fetchInventories(); // Esto probablemente debería ser fetchProducts
        }

        authStore.loading = false;

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
        authStore.loading = false;
    } finally {
        // 7. Desactivar el Global Loader
        loading.value = false;
        authStore.loading = false;
    }
};

const currentPage = ref(1);
const totalPages = ref(1);
const totalSuppliers = ref(0);
const perPage = ref(1);
const error = ref(null);
const suppliersData = ref([]);


const fetchSuppliers = async (search = '',) => {
    loading.value = true;
    error.value = null;

    try {
        const params = {
            // 🎯 CLAVE 1: Envía el parámetro 'per_page' con un valor muy alto
            per_page: 9999,
            search: search,
            // Eliminamos 'page' si no es necesario, o lo dejamos en 1.
            // Si el backend es estricto, es mejor NO enviar 'page' o 'per_page'.
            // Pero si el backend espera la paginación, 'per_page: 9999' es la solución.
        };

        const response = await api.get('/suppliers', { params });
        const responseData = response.data;

        // 🎯 CLAVE 2: Extracción de datos.
        // El objeto paginado tiene la lista en `data`, si no está paginado podría estar directamente.
        // La estructura de tu backend parece ser: { data: { suppliers: { data: [...] } } }

        let fetchedList = [];

        if (responseData && responseData.data && responseData.data.suppliers) {
            // Si el backend sigue devolviendo un objeto paginador (lo más común con per_page: 9999)
            // La lista de proveedores estará en `response.data.data.suppliers.data`
            fetchedList = responseData.data.suppliers.data || [];
        } else if (responseData && responseData.data && responseData.data.length > 0) {
            // Si el backend devuelve el array directamente en responseData.data (sin paginador)
            fetchedList = responseData.data;
        }

        // 4. Actualiza las variables de estado con la lista completa
        suppliersData.value = fetchedList;

        // Reinicia o establece los valores de paginación para reflejar una lista no paginada
        currentPage.value = 1;
        totalPages.value = 1;
        totalSuppliers.value = suppliersData.value.length;

        console.log('Proveedores Obtenidos (Total): ', suppliersData.value);

        /*Swal.fire({
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

onMounted(() => {
    fetchSuppliers(); // Carga la lista al montar el componente
});
</script>
