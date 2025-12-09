<template>
    <div class="p-1 pt-3">

        <div v-if="isLoading" class="flex flex-col items-center justify-center h-64">
            <svg class="animate-spin h-10 w-10 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <p class="mt-4 text-lg font-semibold text-gray-700">Cargando datos generales del dashboard...</p>
        </div>

        <div v-else>

            <div v-if="error" class="text-red-500 text-center mb-6">Error: {{ error }}</div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4" v-if="headerData">

                <div
                    class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-indigo-500 transition duration-300 hover:shadow-xl hover:border-indigo-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500">Ventas del Mes</h3>
                        <i data-lucide="trending-up" class="w-6 h-6 text-indigo-500"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ formatCurrency(currentMonthSales) }}</p>
                    <div class="flex items-center text-sm">
                        <span :class="[monthlyChange >= 0 ? 'text-green-600' : 'text-red-600']"
                            class="font-semibold mr-1">{{ monthlyChange }}%</span>
                        <span class="text-gray-500">Ultimos 30 Días</span>
                    </div>
                </div>
                <div
                    class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-emerald-500 transition duration-300 hover:shadow-xl hover:border-emerald-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500">Ventas del Día</h3>
                        <i data-lucide="trending-up" class="w-6 h-6 text-emerald-500"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ formatCurrency(todaySales) }}</p>
                    <div class="flex items-center text-sm">
                        <span :class="[dailyChange >= 0 ? 'text-green-600' : 'text-red-600']"
                            class="font-semibold mr-1">{{ dailyChange }}%</span>
                        <span class="text-gray-500">Desde Ayer</span>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-orange-500 transition duration-300 hover:shadow-xl hover:border-orange-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500">Valor Inventario</h3>
                        <i data-lucide="package" class="w-6 h-6 text-orange-500"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ formatCurrency(inventoryValue) }}</p>
                    <div class="flex items-center text-sm">
                        <span class="text-gray-500">Valor en (<b>PVP</b>)</span>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-blue-500 transition duration-300 hover:shadow-xl hover:border-blue-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500">Cuentas x Cobrar
                            pendientes</h3>
                        <i data-lucide="wallet" class="w-6 h-6 text-red-500"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ formatCurrency(pendingArAmount) }}</p>
                    <div class="flex items-center text-sm">



                        <span class=" text-1xl text-red-600 font-semibold mr-1"></span>

                        <span
                            class="bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300 px-3 py-1 text-xs font-semibold rounded-full w-fit">{{
                                pendingArCount }} Cuentas pendientes</span>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-blue-500 transition duration-300 hover:shadow-xl hover:border-blue-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500">Clientes Registrados
                        </h3>
                        <i data-lucide="users" class="w-6 h-6 text-blue-500"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ clientsCount.toLocaleString('es-CO') }} <span
                            class="bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300 px-3 py-1 text-xs font-semibold rounded-full w-fit">Sucursal
                            Actual</span> </p>
                    <div class="flex items-center text-sm">
                        <span class="text-1xl text-blue-600 font-semibold mr-1">{{ branchesCount }}</span>
                        <span class="text-gray-500">Sucursales Activas</span>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-violet-500 transition duration-300 hover:shadow-xl hover:border-violet-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500">Artículo Más Vendido
                        </h3>
                        <i data-lucide="star" class="w-6 h-6 text-violet-500"></i>
                    </div>
                    <p class="text-lg font-bold text-gray-900 line-clamp-1 mb-1">{{ bestSeller.name }}</p>
                    <span class="text-1xl font-bold text-violet-600 mb-1">{{
                        bestSeller.quantity_sold.toLocaleString('es-CO') }}</span>
                    <span class="text-gray-500"> Unidades vendidas</span>
                    <div class="flex items-center text-sm">
                    </div>
                </div>
            </div>
            <!--<p>idea Marce</p>-->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 mt-2" v-if="headerData">

                <div
                    class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-indigo-500 transition duration-300 hover:shadow-xl hover:border-indigo-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500">Utilidad Neta </h3>
                        <span
                            class="bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-green-300 px-3 py-1 text-xs font-semibold rounded-full w-fit">
                            Últimos 30 Días</span>
                        <i data-lucide="trending-up" class="w-6 h-6 text-indigo-500"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ formatCurrency(lastMonthGrossProfit.utility_net)
                        }}</p>
                    <div class="flex items-center text-sm">
                        <span :class="[lastMonthGrossProfit.utility_bruta >= 0 ? 'text-green-600' : 'text-red-600']"
                            class="font-semibold mr-1">{{ formatCurrency(lastMonthGrossProfit.utility_bruta) }}</span>
                        <span class="text-gray-500">Utilidad Bruta</span>
                    </div>
                </div>
                <div
                    class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-emerald-500 transition duration-300 hover:shadow-xl hover:border-emerald-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500">Total Descuentos</h3>
                        <i data-lucide="trending-up" class="w-6 h-6 text-emerald-500"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ formatCurrency(lastMonthGrossProfit.discount) }}
                    </p>
                    <div class="flex items-center text-sm">
                        <span :class="[lastMonthGrossProfit.discount_percent >= 0 ? 'text-green-600' : 'text-red-600']"
                            class="font-semibold mr-1">{{ lastMonthGrossProfit.discount_percent }} %</span>
                        <span class="text-gray-500">Descuento Colaboradores (DPC)</span>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-orange-500 transition duration-300 hover:shadow-xl hover:border-orange-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500">Valor Inventario</h3>
                        <i data-lucide="package" class="w-6 h-6 text-orange-500"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ formatCurrency(inventoryValuePurchasePrice) }}
                    </p>
                    <div class="flex items-center text-sm">
                        <span class="text-gray-500">Valor en (<b>PNC</b>)</span>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-green-500 transition duration-300 hover:shadow-xl hover:border-green-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500">cuentas x cobrar
                            pagadas</h3>
                        <i data-lucide="wallet" class="w-6 h-6 text-red-500"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ formatCurrency(paidARTotalAmount) }}</p>
                    <div class="flex items-center text-sm">
                        <span
                            class="bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300 px-3 py-1 text-xs font-semibold rounded-full w-fit">{{
                                paidARCount }} Cuentas pagadas</span>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-red-500 transition duration-300 hover:shadow-xl hover:border-red-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500">ventas Anuladas
                        </h3>
                        <i data-lucide="users" class="w-6 h-6 text-blue-500"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ formatCurrency(canceledSalesTotal) }}
                             </p>
                    <div class="flex items-center text-sm">
                        <span class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300 px-3 py-1 text-xs font-semibold rounded-full w-fit">{{ canceledSalesCount }}  Ventas Anuladas.</span>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-green-500 transition duration-300 hover:shadow-xl hover:border-green-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500">Utilidad Promedio Inventario
                        </h3>
                        <i data-lucide="star" class="w-6 h-6 text-violet-500"></i>
                    </div>
                    <p class="text-3xl font-bold font-bold text-gray-900 line-clamp-1 mb-1"
                    :class="[avgRealMarginInventoty >= 0 ? 'text-green-600' : 'text-red-600']"
                    >{{ formatCurrency(avgRealMarginInventoty).replace('$', '')}} %</p>
                    <span class="text-1xl font-bold text-violet-600 mb-1">{{
                        activeCountInventoty }}</span>
                    <span class="text-gray-500"> Producos Activos</span>
                    <div class="flex items-center text-sm">


                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted, computed } from 'vue'
import api from '@/plugins/axios'


// --- UTILIDADES ---
const formatCurrency = (value) => {
    // Función simple de formateo de moneda
    if (typeof value !== 'number') return '$0';
    return '$' + value.toLocaleString('es-CO', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
};

// --- VARIABLES REACTIVAS DE CARGA Y DATOS ---
const isLoading = ref(true); // Único estado de carga
const error = ref(null);

const headerData = ref(null);
const inventoryValue = ref(0);
const pendingArAmount = ref(0);
const pendingArCount = ref(0);
const todaySales = ref(0);
const dailyChange = ref(0);
const clientsCount = ref(0);
const branchesCount = ref(0);
const lastMonthSales = ref(0);
const monthlyChange = ref(0);
const currentMonthSales = ref(0);
const lastMonthGrossProfit = ref(0);
const bestSeller = ref({ name: 'N/A', sku: 'N/A', quantity_sold: 0 });



const paidARTotalAmount = ref(0);
const paidARCount = ref(0);
const inventoryValuePurchasePrice = ref(0);

const canceledSalesTotal = ref(0);
const canceledSalesCount = ref(0);



const avgRealMarginInventoty = ref(0);
const activeCountInventoty = ref(0);





// --- FIN VARIABLES HEADER ---


// --- FUNCIÓN PARA OBTENER LOS DATOS DEL ENCABEZADO ---
const fetchGeneralHeaderData = async () => {
    isLoading.value = true;
    error.value = null; // Limpia errores anteriores
    try {
        const { data } = await api.get('/data/generalDashboard');

        console.log('data :: ', data)

        if (data.success && data.data) {
            const metrics = data.data;
            headerData.value = metrics;

            // Mapeo de métricas
            inventoryValue.value = metrics.current_inventory_value;
            pendingArAmount.value = metrics.pending_ar_total_amount;
            pendingArCount.value = metrics.pending_ar_count;
            todaySales.value = metrics.today_sales_amount;
            dailyChange.value = metrics.daily_change_percent;
            clientsCount.value = metrics.current_clients_count;
            branchesCount.value = metrics.active_branches_count;
            lastMonthSales.value = metrics.last_month_sales_amount;
            currentMonthSales.value = metrics.current_month_sales_amount;
            monthlyChange.value = metrics.sales_change_percent;
            lastMonthGrossProfit.value = metrics.last_month_gross_profit;
            bestSeller.value = metrics.best_selling_product || { name: 'N/A', sku: 'N/A', quantity_sold: 0 };

            paidARTotalAmount.value = metrics.paid_ar_total_amount;
            paidARCount.value = metrics.paid_ar_count;

            inventoryValuePurchasePrice.value = metrics.inventory_value_urchase_price;

            canceledSalesTotal.value = metrics.canceled_sales_total;
            canceledSalesCount.value = metrics.canceled_sales_count;
            avgRealMarginInventoty.value = metrics.avg_real_margin_inventoty;
            activeCountInventoty.value = metrics.active_count_inventoty;


        }
    } catch (err) {
        console.error('Error al cargar datos del encabezado:', err);
        error.value = 'Fallo al obtener los datos del dashboard.';
    } finally {
        isLoading.value = false;
    }
};

defineExpose({
    fetchGeneralHeaderData // Solo exponemos la función necesaria
});


onMounted(() => {
    fetchGeneralHeaderData();
})
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
