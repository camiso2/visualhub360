<script setup>
import { Line } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    CategoryScale,
    LinearScale,
    PointElement
} from "chart.js";

// Registrar módulos
ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    CategoryScale,
    LinearScale,
    PointElement
);

// Props del componente
const props = defineProps({
    chartData: { type: Object, required: true },
    chartOptions: { type: Object, default: () => ({}) }
});

// Opciones finales **forzando sin título ni leyenda**
const finalOptions = {
    responsive: true,
    maintainAspectRatio: false,
    ...props.chartOptions,

    plugins: {
        ...(props.chartOptions.plugins || {}),

        // 🔥 Leyenda siempre oculta
        legend: {
            ...props.chartOptions.plugins?.legend,
            display: false,
            labels: {
                display: false,
                boxWidth: 0
            }
        },

        // 🔥 Título siempre oculto
        title: {
            ...props.chartOptions.plugins?.title,
            display: false,
            text: ""
        }
    }
};


</script>

<template>
    <Line :data="props.chartData" :options="finalOptions" />
</template>
