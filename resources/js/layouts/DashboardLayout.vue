<template>
    <div class="flex h-screen bg-gray-100 overflow-hidden">
        <!-- Overlay Oscuro (Solo Móvil) -->
        <!-- Aparece cuando el sidebar está abierto y se cierra al hacer click fuera -->
        <div v-if="isSidebarOpen" class="fixed inset-0 bg-black opacity-50 z-20 md:hidden" @click="toggleSidebar">
        </div>
        <Sidebar :is-open="isSidebarOpen" @toggle-sidebar="toggleSidebar" />
        <div class="flex-1 flex flex-col overflow-y-auto overflow-x-hidden">
            <TopBar :is-open="isSidebarOpen" @toggle-sidebar="toggleSidebar" />
            <main class="flex-grow p-4">
            </main>
            <Footer />
        </div>
    </div>
</template>


<script setup>
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/useAuthStore' // IMPORTAR LA STORE
import Footer from '@/components/Footer.vue'
import TopBar from '@/components/TopBar.vue'
import Sidebar from '@/components/Sidebar.vue'

import { ref, onMounted } from 'vue';

const router = useRouter()
const authStore = useAuthStore() // INICIALIZAR LA STORE
const isSidebarOpen = ref(true);

// FUNCIÓN DE TOGGLE
const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
    console.log("Sidebar toggled in Layout:", isSidebarOpen.value);
};


const loading = ref(false);
/*onMounted(() => {
    loading.value = true;
    if (!authStore.isAuthenticated) {
        router.push({ name: 'Login' });
    }
    loading.value = false;
});*/




</script>
