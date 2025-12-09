

<template>


    <div class="flex flex-col w-full md:w-48">
      <label class="text-sm font-medium text-gray-700">Departamento *</label>
      <select v-model="selectedDepartment" required :class="inputClasses">
        <option disabled value="">Seleccione un Departamento...</option>
        <option
          v-for="dept in COLOMBIAN_LOCATIONS"
          :key="dept.id"
          :value="dept.departamento"
        >
          {{ dept.departamento }}
        </option>
      </select>
    </div>

    <div class="flex flex-col w-full md:w-48">
      <label class="text-sm font-medium text-gray-700">Ciudad *</label>
      <select
        v-model="selectedCity"
        required
        :disabled="!selectedDepartment"
        :class="inputClasses"
      >
        <option disabled value="">
          {{ selectedDepartment ? 'Seleccione un Municipio...' : 'Primero seleccione un Departamento' }}
        </option>
        <option v-for="city in availableCities" :key="city" :value="city">
          {{ city }}
        </option>
      </select>
    </div>


</template>
<script setup>
import { computed, watch } from 'vue';

// 💡 IMPORTAR LA DATA:
// Asume que el archivo colombia_locations.json está disponible y se puede importar
// Nota: La sintaxis de importación puede variar dependiendo de tu configuración de Webpack/Vite.
import COLOMBIAN_LOCATIONS from './data/colombia_locations.json';

// Definimos las props (para usar v-model)
const props = defineProps({
  department: { type: String, default: '' },
  city: { type: String, default: '' },
});

// Definimos los eventos
const emit = defineEmits(['update:department', 'update:city']);

// --- Lógica de Manejo de Estado ---

// 1. Manejo del Departamento Seleccionado
const selectedDepartment = computed({
  get: () => props.department,
  set: (newValue) => {
    emit('update:department', newValue);
  },
});

// 2. Manejo de la Ciudad Seleccionada
const selectedCity = computed({
  get: () => props.city,
  set: (newValue) => {
    emit('update:city', newValue);
  },
});

// 3. Ciudades disponibles (filtradas)
const availableCities = computed(() => {
  const dept = COLOMBIAN_LOCATIONS.find(
    (d) => d.departamento === selectedDepartment.value
  );
  return dept ? dept.ciudades : [];
});

// 4. Resetear la ciudad cuando el departamento cambia
watch(selectedDepartment, (newDept, oldDept) => {
  // Solo reseteamos la ciudad si el departamento realmente cambió y no está vacío
  if (newDept !== oldDept) {
    selectedCity.value = '';
  }
});

// Clases CSS reutilizables para los selects, replicando el estilo de tus inputs
const inputClasses =
  'bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2.5 shadow-xs';
</script>
