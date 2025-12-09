<script setup>
import { Doughnut } from 'vue-chartjs';
// Importa los elementos necesarios para el Gráfico de Dona
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    ArcElement // Elemento clave para gráficos circulares
} from 'chart.js';

// Registra los componentes
ChartJS.register(Title, Tooltip, Legend, ArcElement);

const props = defineProps({
  chartData: {
    type: Object,
    required: true,
  },
  chartOptions: {
    type: Object,
    default: () => ({
      responsive: true,
      maintainAspectRatio: false,
      cutout: '80%', // Define el tamaño del agujero (80% del radio)
    }),
  },
});
</script>

<template>
  <Doughnut
    :data="props.chartData"
    :options="props.chartOptions"
  />
</template>
