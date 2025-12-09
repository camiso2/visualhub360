<script setup>
import { Bar } from 'vue-chartjs';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
} from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const props = defineProps({
    chartData: {
        type: Object,
        required: true,
    },
    chartOptions: {
        type: Object,
        default: () => ({}),
    },
});

// Combina opciones, pero **siempre forzando la leyenda apagada**
const finalOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false,   // 🔥 Forzado SIEMPRE
        },title: {
        display: false,
    },

    },
    ...props.chartOptions,
    plugins: {
        ...props.chartOptions.plugins,
        legend: {
            display: false,   // 🔥 vuelves a forzar aquí en caso de override
        },title: {
        display: false,
    },
    },
};
</script>

<template>
    <Bar :data="props.chartData" :options="finalOptions" />
</template>
