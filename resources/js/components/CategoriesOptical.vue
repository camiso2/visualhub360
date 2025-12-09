<template>
    <div class="flex flex-col w-full md:w-50">
        <label for="product-category" class="text-sm font-medium text-gray-700">
            Categoría *
        </label>

        <select
            id="product-category"
            :value="modelValue"
            @change="$emit('update:modelValue', $event.target.value)"
            required
            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base
                   focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs"
        >
            <option value="" disabled>Seleccione una categoría o subcategoría...</option>

            <optgroup
                v-for="(category, index) in CATEGORIAS_OPTICA"
                :key="index"
                :label="category.name"
            >
                <option :value="category.name">
                    --- {{ category.name }} (General) ---
                </option>

                <option
                    v-for="(sub, subIndex) in category.subcategories"
                    :key="`${index}-${subIndex}`"
                    :value="sub"
                >
                    &nbsp;&nbsp;&nbsp;&nbsp;{{ sub }}
                </option>
            </optgroup>
        </select>
    </div>
</template>

<script setup>
import {  ref } from 'vue';

// Array de categorías (debe estar en el mismo archivo o importarse)
const CATEGORIAS_OPTICA = [
    // --- CATEGORIAS PRINCIPALES (Corrección y Visión) ---
    {
        name: "Monturas Oftálmicas",
        description: "Armazones diseñados para llevar lentes correctivos formulados.",
        subcategories: [
            "Metal",
            "Acetato/Plástico",
            "Titanio",
            "Monturas al Aire (Sin Aro)",
            "Semi-Aire (Media Montura)"
        ]
    },
    {
        name: "Lentes Oftálmicos (Cristales)",
        description: "Lentes correctivos según la fórmula visual del paciente.",
        subcategories: [
            "Monofocales (Visión Sencilla)",
            "Bifocales",
            "Progresivos / Multifocales",
            "Ocupacionales / Antifatiga",
            "Material Orgánico/Resina",
            "Material Policarbonato"
        ]
    },
    {
        name: "Tratamientos y Filtros",
        description: "Recubrimientos y filtros aplicados a los lentes oftálmicos.",
        subcategories: [
            "Antirreflejo Estándar",
            "Antirreflejo Blue Light (Luz Azul)",
            "Filtro UV",
            "Fotocromáticos / Transitions",
            "Antirrayas / Endurecido"
        ]
    },
    {
        name: "Lentes de Contacto",
        description: "Dispositivos que se colocan directamente sobre la córnea.",
        subcategories: [
            "Desechables Diarios",
            "Desechables Quincenales/Mensuales",
            "Tóricos (Para Astigmatismo)",
            "Multifocales (Para Presbicia)",
            "Cosméticos / De Color"
        ]
    },

    // --- CATEGORIAS DE PROTECCIÓN ---
    {
        name: "Gafas de Sol",
        description: "Gafas de protección solar, con o sin fórmula.",
        subcategories: [
            "Sin Graduación",
            "Graduadas (Con Fórmula)",
            "Polarizadas",
            "Deportivas",
            "Especializadas (Nieve/Ciclismo)"
        ]
    },
    {
        name: "Protección Ocupacional/Especial",
        description: "Gafas de seguridad para entornos laborales o específicos.",
        subcategories: [
            "Gafas de Seguridad Industrial",
            "Gafas para PC (Filtro Luz Azul)",
            "Gafas de Bioseguridad"
        ]
    },

    // --- CATEGORIAS DE MANTENIMIENTO Y ACCESORIOS ---
    {
        name: "Líquidos y Soluciones",
        description: "Productos para la limpieza y desinfección de lentes de contacto.",
        subcategories: [
            "Solución Multipropósito",
            "Solución Salina",
            "Solución de Peróxido",
            "Gotas Rehumectantes"
        ]
    },
    {
        name: "Accesorios y Repuestos",
        description: "Complementos para gafas y kits de limpieza.",
        subcategories: [
            "Estuches y Fundas",
            "Cadenas y Cuerdas",
            "Paños de Microfibra",
            "Kits de Limpieza",
            "Repuestos (Almohadillas, Tornillos)"
        ]
    },

    // --- OTRAS CATEGORIAS DE VENTA ---
    {
        name: "Productos de Baja Visión",
        description: "Ayudas ópticas para personas con baja visión.",
        subcategories: [
            "Lupas de Mano",
            "Lupas Electrónicas",
            "Telescopios de Enfoque Fijo"
        ]
    },
    {
        name: "Mercancía / Otros",
        description: "Otros artículos relacionados o de venta general en la óptica.",
        subcategories: [
            "Limpiadores Ultrasónicos",
            "Tarjetas de Regalo",
        ]
    }
];

// 1. Define las props (para usar v-model)
const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    }
});

// 2. Define los eventos (para usar v-model)
const emit = defineEmits(['update:modelValue']);
</script>
