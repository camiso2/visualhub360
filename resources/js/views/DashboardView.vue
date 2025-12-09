<template>
    <div class="lg:col-span-3">
        <DataGeneral />
    </div>
    <div
        class="bg-white p-2 shadow-lg rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700 mt-3 ml-1 mr-1">

        <HeaderButtonGenInformComplet :title="`Gráficas estadísticas `" :isDopDownVisible=true>
            <template #icon>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8.25v-2.5m0 0c0-.69-.56-1.25-1.25-1.25H6.25A1.25 1.25 0 005 4.75v14.5c0 .69.56 1.25 1.25 1.25h4.5c.69 0 1.25-.56 1.25-1.25v-2.5m0-12.5h3.5c.69 0 1.25.56 1.25 1.25v3.5m-4.75 7.25h6.5c.69 0 1.25-.56 1.25-1.25V9.75L15.5 6H12m0 8.25H9.75m2.25 3H9.75" />
                </svg>

            </template>
        </HeaderButtonGenInformComplet>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-0 md:gap-6 px-0 md:px-0 w-full ">
            <!-- ========== LISTA DE SUCURSALES (1/3) ========== -->
            <div
                class="w-full min-w-0 p-3 bg-white shadow-lg rounded-xl border border-gray-100 col-span-full md:col-span-1 mt-1 ">
                <!-- TÍTULO -->
                <h2 class="text-lg font-semibold text-gray-700 mb-4 flex flex-col">
                    <!--<span class="text-xs tracking-wide uppercase text-gray-500 font-bold coompany-title-color">
                            {{ authStore.user.company.name.toUpperCase() }}
                        </span>-->
                    <span class="flex items-center gap-2 text-xl text-gray-700">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7l1.5-4h15L21 7M4 7h16v11a2 2 0 01-2 2H6a2 2 0 01-2-2V7z" />
                        </svg>
                        Sucursales <span class="bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300 px-3 py-1 text-xs font-semibold rounded-full w-fit">Activas</span>
                    </span>


                </h2>
                  <hr >

                <div class="h-[350px] overflow-y-auto pr-1 custom-scroll mt-3 ">
                    <ul class="space-y-3">

                        <li v-for="(sucursal, index) in sucursales" :key="index"
                            class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition">

                            <!-- Color cuadrado -->
                            <span class="w-4 h-4 rounded-md shadow-sm border border-gray-200"
                                :style="{ backgroundColor: sucursal.color }">
                            </span>

                            <!-- Nombre -->
                            <span class="text-gray-700 text-sm font-medium leading-tight">
                                {{ sucursal.nombre }}
                            </span>


                        </li>

                    </ul>
                </div>


            </div>

            <!-- ========== GRÁFICO (1/3) ========== -->
            <div class="bg-white shadow-lg rounded-xl border border-gray-100 col-span-2 mt-1">
                <div class="p-5">

                    <h2 class="text-xl font-bold text-gray-700 mb-5 flex items-center">
                        <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" role="img"
                            aria-label="Gráfico de línea">
                            <title>Gráfico de línea</title>
                            <path d="M3 17l4-6 4 2 6-8 4 10" />
                            <path d="M3 21h18" stroke-opacity="0.5" />
                        </svg>
                        Tendencia de Ventas por Sucursales <span class="bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300 px-3 py-1 text-xs font-semibold rounded-full w-fit">Datos Para Ultima Semana </span>
                    </h2>
                    <div class="h-[350px]">
                        <LineChart :chartData="weeklySalesData" :chartOptions="lineChartOptions" />
                    </div>
                </div>
            </div>
        </div>



        <div class=" grid grid-cols-1 md:grid-cols-3 gap-0 md:gap-6 px-0 md:px-0 w-full">
            <!-- ========== LISTA DE SUCURSALES (1/3) ========== -->
            <div
                class="w-full min-w-0 p-3 bg-white shadow-lg rounded-xl border border-gray-100 col-span-full md:col-span-1 mt-3 pb-3">
                <h2 class="text-lg font-semibold text-gray-700 mb-1 flex flex-col mt-1">
                    <!--<span class="text-xs tracking-wide uppercase text-gray-500 font-bold coompany-title-color">
                            {{ authStore.user.company.name.toUpperCase() }}
                        </span>-->
                    <span class="flex items-center gap-2 text-xl text-gray-700">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7l1.5-4h15L21 7M4 7h16v11a2 2 0 01-2 2H6a2 2 0 01-2-2V7z" />
                        </svg>
                        Distribución de Ventas <span class="bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300 px-3 py-1 text-xs font-semibold rounded-full w-fit">Productos Todas las Sucursales</span>
                    </span>

                </h2>
                <hr class="mt-3">

                <div class="bg-white p-0  dark:bg-gray-800 dark: mt-3">
                    <div class="relative inset-0 flex items-center justify-center pointer-events-none">
                            <span class="text-3xl font-extrabold text-indigo-600 mt-1">100%</span>
                        </div>
                    <div style="height: 300px; width: 300px; margin: 0 auto; position: relative;">
                        <DoughnutChart v-if="doughnutData.labels.length > 0" :chartData="doughnutData"
                            :options="doughnutOptions" />
                        <div v-else class="flex items-center justify-center h-full text-gray-500">
                            Cargando data...
                        </div>

                    </div>
                </div>
            </div>

            <!-- ========== GRÁFICO (1/3) ========== -->
            <div class="bg-white shadow-lg rounded-xl border border-gray-100 col-span-2 mt-3 ">
                <div class="p-5">

                    <h2 class="text-xl font-bold text-gray-700 mb-5 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            xmlns="http://www.w3.org/2000/svg" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round" role="img" aria-label="Bar chart">
                            <title>Bar chart</title>
                            <rect x="3.5" y="11" width="3.5" height="8" rx="0.6" />
                            <rect x="9.5" y="7" width="3.5" height="12" rx="0.6" />
                            <rect x="15.5" y="4" width="3.5" height="15" rx="0.6" />
                            <path d="M2 21h20" />
                        </svg>
                        Tendencia de Ventas por Sucursales   <span class="bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300 px-3 py-1 text-xs font-semibold rounded-full w-fit">Datos Para Ultimo Semestre</span>
                    </h2>
                    <div class="h-[350px]">
                        <BarChart :chartData="salesChartData" :chartOptions="chartOptions" />
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue';
import { useAuthStore } from '@/stores/useAuthStore';
// En DashboardView.vue
import api from "@/plugins/axios";

import DataGeneral from '../components/DataGeneral.vue';
import BarChart from '../components/graphics/BarChart.vue';
import LineChart from '../components/graphics/LineChart.vue';
import DoughnutChart from '../components/graphics/DoughnutChart.vue';
import HeaderButtonGenInformComplet from '../components/HeaderButtonGenInformComplet.vue'


// --- 1. DATOS DEL GRÁFICO ---
// Los nombres de las propiedades deben ser label, datasets
// Variable reactiva que contendrá los datos para el gráfico
const salesChartData = ref({
    labels: [],
    datasets: []
});

const isLoadingChart = ref(false);
const chartError = ref(null);

/**
 * Función que llama al API para obtener los datos de ventas por sucursal
 * y actualiza la variable reactiva 'salesChartData'.
 */
const fetchSalesChartData = async () => {
    isLoadingChart.value = true;
    chartError.value = null;

    try {
        // Usamos la instancia 'api' ya configurada
        const response = await api.get('/data/salesChartData');
        // Nota: Asegúrate de usar la ruta completa o la ruta relativa correcta según la configuración de tu plugin.

        // Verificar la respuesta exitosa
        if (response.data.success && response.data.data) {

            // Actualizar la variable reactiva con los datos del campo 'data'
            // La estructura de 'response.data.data' (labels y datasets) es la que necesitamos
            salesChartData.value = response.data.data;

        } else {
            // Manejar errores si la respuesta de la API no es "success: true"
            chartError.value = response.data.message || 'La estructura de datos de la API es inválida.';
        }

    } catch (error) {
        // Manejar errores de red o errores HTTP (4xx/5xx)
        console.error('Error al cargar la data del gráfico:', error);

        // Puedes acceder al mensaje de error específico si Axios lo proporciona
        const errorMessage = error.response?.data?.message || 'Error desconocido al conectar con la API.';
        chartError.value = `Error: ${errorMessage}`;

    } finally {
        isLoadingChart.value = false;
    }
};



// --- 1. DATOS DEL GRÁFICO (Reactivo) ---
// Inicializamos la data del gráfico con una estructura vacía para evitar errores de renderizado.
const doughnutData = ref({
    labels: [],
    datasets: [],
});

// --- 2. OPCIONES DEL GRÁFICO (Tal como lo definiste) ---
const doughnutOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
    cutout: '75%', // Hace que el agujero sea del 75% del radio
    plugins: {
        legend: {
            display: true, // Asegurar que la leyenda se muestre
            position: 'bottom', // Mueve la leyenda abajo
            labels: {
                // Personalización opcional de la leyenda
                usePointStyle: true,
            }
        },
        tooltip: {
            callbacks: {
                // Muestra el valor como porcentaje y el monto formateado en el tooltip
                label: (context) => {
                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                    const value = context.parsed;
                    const percentage = ((value / total) * 100).toFixed(1) + '%';
                    // Formatea el valor a moneda local (ej: $1,230,000)
                    const formattedValue = value.toLocaleString('es-CO', {
                        style: 'currency',
                        currency: 'COP',
                        minimumFractionDigits: 0
                    });

                    return ` ${context.label}: ${percentage} (${formattedValue})`;
                }
            }
        }
    },
});

// --- 3. MÉTODO DE CARGA DE DATOS ---

const loadDoughnutChartData = async () => {


    try {
        // Usamos tu instancia de axios importada
        const response = await api.get('/data/productSalesDistribution');

        // Verificación de la respuesta
        if (response.data.success && response.data.data) {
            // Asignamos el objeto de datos (labels y datasets) directamente a la ref
            doughnutData.value = response.data.data;
            console.log("Datos del gráfico Donut cargados:", doughnutData);
        } else {
            console.error("API no exitosa o datos vacíos:", response.data.message);
        }

    } catch (error) {
        console.error("Error al cargar los datos del gráfico Donut:", error);
    }
};

// Llama a la función cuando el componente esté montado
onMounted(() => {
    fetchSalesChartData();
    loadChartData();
    loadDoughnutChartData();
});






// --- 1. DATOS DEL GRÁFICO DE DONA ---
const salesDistributionData = ref({
    labels: ['Gafas de Sol', 'Lentes de Contacto', 'Exámenes Visuales'],
    datasets: [
        {
            label: 'Distribución de Ventas',
            // Colores de Tailwind para los segmentos (ej. Indigo, Emerald, Amber)
            backgroundColor: ['#4f46e5', '#10b981', '#f59e0b'],
            data: [45, 30, 25], // Porcentajes o valores (deben sumar 100 o el total)
            // Ajuste el borde para un aspecto más limpio
            borderColor: '#ffffff',
            borderWidth: 2,
        },
    ],
});






// --- 1. DATOS DEL GRÁFICO ---
// Inicializamos la data del gráfico como reactiva.
// La estructura inicial es un placeholder y será rellenada por la API.
const weeklySalesData = ref({
    labels: [],
    datasets: [],
});

// --- 2. OPCIONES DEL GRÁFICO (Ajustadas para Multilínea) ---
const lineChartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        title: {
            display: true,
            text: 'Tendencia de Ventas de Sucursales (Última Semana)',
            font: {
                size: 18,
            }
        },
        legend: {
            display: true, // Importante: Muestra la leyenda para identificar las sucursales
            position: 'bottom', // Mueve la leyenda a la parte inferior
            labels: {
                usePointStyle: true, // Hace que los indicadores de la leyenda sean pequeños puntos o líneas
            }
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            title: {
                display: true,
                text: 'Monto de Ventas ($)',
            },
            // Formato de los ticks del Eje Y (ej. para miles)
            ticks: {
                callback: function (value, index, ticks) {
                    // Formato básico de moneda, ajusta según tu necesidad (ej. $1.000.000)
                    return '$' + value.toLocaleString();
                }
            }
        },
        x: {
            title: {
                display: true,
                text: 'Días de la Semana',
            }
        }
    }
});

// --- 3. MÉTODO DE CARGA DE DATOS ---

const loadChartData = async () => {
    try {
        const response = await api.get('/data/weeklyBranchSalesLineData');
        if (response.data.success && response.data.data) {
            // Mapeamos directamente la respuesta 'data' de la API a nuestra variable reactiva
            weeklySalesData.value = response.data.data;

            console.log("Datos del gráfico cargados:", weeklySalesData.value);
        } else {
            console.error("API no exitosa:", response.data.message);
        }

    } catch (error) {
        console.error("Error al cargar los datos del gráfico:", error);
    }
};






// --- 2. OPCIONES DEL GRÁFICO (Opcional) ---
const chartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        title: {
            display: true,
            text: 'Ventas Comparativas Mensuales',
            font: {
                size: 16
            }
        },
        legend: {
            position: 'top',
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            title: {
                display: true,
                text: 'Monto ($)'
            }
        }
    }
});


const authStore = useAuthStore();
// Usuario actual
// Usuario actual desde el store
const user = computed(() => authStore.user)




const sucursales = computed(() => {
    if (!salesChartData.value?.datasets) return [];

    return salesChartData.value.datasets.map(item => ({
        nombre: item.label,
        color: item.backgroundColor
    }));
});



// Usamos una propiedad computada para mostrar solo una parte del token,
// ya que es muy largo y desordenaría la interfaz.
const shortToken = computed(() => {
    const token = authStore.token;
    if (!token) return 'Token no encontrado';

    // Muestra los primeros 10 caracteres y los últimos 5
    return `${token.substring(0, 10)}...${token.substring(token.length - 5)}`;
});
</script>

<style scoped>
/* Tu estilo Tailwind */
</style>
