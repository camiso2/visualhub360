// src/stores/useAuthStore.js

import { defineStore } from 'pinia';
import api from '@/plugins/axios'; // Asume que 'api' es tu instancia de Axios configurada

export const useAuthStore = defineStore('auth', {
    // 1. STATE (ESTADO)
    // -------------------------------------------------------------
    state: () => ({
        user: null,
        branch: null,
        token: null,
        error: null,
        loading: false,// Estado de carga interno para el store (opcionalmente puedes usarlo para spinners globales)
        isAppLoading: false
    }),

    // 2. ACTIONS (LÓGICA)
    // -------------------------------------------------------------
    actions: {
        /**
         * Limpia de forma segura el estado local.
         */
        clearLocalState() {
            this.token = null;
            this.user = null;
            this.branch = null;
            this.error = null;

            // Si no tienes un interceptor, elimina el token del header global de Axios
            if (api.defaults.headers.common['Authorization']) {
                 delete api.defaults.headers.common['Authorization'];
            }
        },

        /**
         * Intenta iniciar sesión con las credenciales proporcionadas.
         * Devuelve el objeto completo de la API que incluye 'needs_branch_setup'.
         */
        async login(credentials) {
            this.clearLocalState(); // Limpiar el estado ANTES de la llamada
            this.loading = true; // Iniciar carga
            this.isAppLoading = true;

            try {
                const response = await api.post('/login', credentials);
                // Extraemos los datos que Laravel devuelve dentro de 'data'
                const { token, user, branch, needs_branch_setup } = response.data.data;

                // 1. Guardar estado de Pinia
                this.token = token;
                this.user = user;
                this.branch = branch;
                this.error = null;

                // 2. CRÍTICO: Configurar el token para futuras llamadas
                api.defaults.headers.common['Authorization'] = `Bearer ${token}`;

                // 3. Devolver el objeto de datos COMPLETO, incluyendo la bandera de configuración
                console.log('Login successful:', response.data.data);
                return response.data.data;


            } catch (error) {
                // Manejo de errores
                this.error = error.response?.data?.message || 'Error en el inicio de sesión o de red.';
                this.clearLocalState();

                // Lanza el error para que el 'catch' en el componente de Vue lo atrape
                throw error;
            } finally {
                this.loading = false; // Detener carga
            }
        },

        /**
         * Valida el token actual llamando a la ruta /me para refrescar los datos.
         * Es crucial para la persistencia de la sesión.
         */
        async fetchUser() {
            if (!this.token) return false;

            this.loading = true;

            try {
                const response = await api.get('/me');
                const { user, branch, last_invoice_number } = response.data.data;

                // Actualizar los datos del usuario y la sucursal activa
                this.user = user;
                this.branch = branch;
                this.last_invoice_number = last_invoice_number;
                this.error = null;

                // Devolvemos los datos por si alguna lógica en el frontend los necesita (ej. bandera needs_branch_setup si /me la devuelve)
                return response.data.data;

            } catch (error) {
                // Si la petición falla (e.g., error 401 Unauthorized o 500), el token es inválido o la sesión expiró.
                this.clearLocalState();
                throw error;
            } finally {
                this.loading = false;
            }
        },

        /**
         * Cierra la sesión, notificando al servidor y limpiando el estado local.
         */
        async logout() {
            // Intentamos notificar al servidor (la llamada fallará si el token ya expiró, lo ignoramos)
            try {
                await api.post('/logout');
            } catch (e) { /* Ignoramos el error de notificación */ }

            // Limpiamos el estado local de forma segura.
            this.clearLocalState();
        }
    },

    // 3. PERSIST (PERSISTENCIA)
    // -------------------------------------------------------------
    persist: {
        storage: localStorage,
        paths: ['token', 'user', 'branch','last_invoice_number']
    }
});
