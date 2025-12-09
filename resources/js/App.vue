<template>
    <div id="app-container" class="min-h-screen bg-gray-100 antialiased">
        <router-view></router-view>
        <GlobalLoader />
    </div>
</template>

<script setup>
// No necesita lógica aquí, solo actúa como el layout principal.
import GlobalLoader from './components/GlobalLoader.vue';
</script>

<style>
/* Estilos globales si son necesarios */
</style>
