// src/main.js

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';

import { capitalizeWords,openImageViewer,getFormatDecimal,getFormatInteger, getFormatCurrency } from './utils/helpers'; // 👈 Importa tus funciones
import { getErrorMessage } from './utils/errorHelper';
import GlobalLoader from '@/components/GlobalLoader.vue';


const app = createApp(App);
const pinia = createPinia();

// 1. Instalar el plugin
pinia.use(piniaPluginPersistedstate); // CRÍTICO

// Para capitalizar cada palabra (Title Case)
app.config.globalProperties.$capitalizeWords = capitalizeWords;
app.config.globalProperties.$openImageViewer = openImageViewer;
app.config.globalProperties.$getErrorMessage = getErrorMessage;
app.config.globalProperties.$getFormatDecimal = getFormatDecimal;
app.config.globalProperties.$getFormatInteger = getFormatInteger;
app.config.globalProperties.$getFormatCurrency = getFormatCurrency;


// 2. Usar Pinia y Router
app.use(pinia);
// ELIMINAR la llamada manual a authStore.loadSession()


app.use(router);
app.mount('#app');


