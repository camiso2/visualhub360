// resources/js/plugins/axios.js
import axios from 'axios';
import router from '@/router';
import { useAuthStore } from '@/stores/useAuthStore';

const api = axios.create({
    baseURL: 'http://localhost:8001/api',
    headers: { Accept: 'application/json' }
});

/* -------- Request -------- */
api.interceptors.request.use(config => {
    const authStore = useAuthStore();
    if (authStore.token) {
        config.headers.Authorization = `Bearer ${authStore.token}`;
    }
    return config;
});

/* -------- Response -------- */
api.interceptors.response.use(
    res => res,
    err => {
        const authStore = useAuthStore();
        const status = err.response?.status;
        const msg = err.response?.data?.message;

        if (status === 401) {
            authStore.clearLocalState();
            if (router.currentRoute.value.path !== '/login') router.push('/login');
            return Promise.reject(err);
        }

        if (status === 403 && msg === 'Sucursal_inactiva') {
            // alert(msg); // ✅ simple y funcional
            Swal.fire({
                icon: "error",
                title: "<strong>Sucursal Inactiva</strong>",
                html: `
                    No es posible continuar porque esta sucursal se encuentra deshabilitada.<br>
                    <span style="font-size:14px;color:#555;">
                        Por favor comunícate con el administrador del sistema.
                    </span>
                `,
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#0ea5e9",
                background: "#f8fafc",
                color: "#1e293b",
                footer: "<span style='font-weight:600;color:#475569;'>VISIONHUB 360</span>"
            });

            /*Swal.fire({
                icon: "info",
                title: "Acceso Restringido",
                html: `
                    La sucursal asociada a este usuario está actualmente <b>inactiva</b>.<br>
                    Para continuar, solicita al administrador la reactivación correspondiente.
                `,
                showCloseButton: true,
                confirmButtonText: "Cerrar",
                confirmButtonColor: "#2563eb",
                footer: "<small>VISIONHUB 360 • Sistema Centralizado</small>"
            });*/




            router.replace({ name: 'BranchBlocked' });
        }

        return Promise.reject(err);
    }
);

export default api;




// @/plugins/axios.js (Asegúrate de que esta lógica esté aquí o en tu archivo de inicialización de Axios)

/*import axios from 'axios';
import router from '@/router'; // Asegúrate de tener el router importado
import { useAuthStore } from '@/stores/useAuthStore'; // Importa el store

const api = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {
        'Accept': 'application/json',
    },
});

// 1. Interceptor de Solicitud (Request Interceptor)
api.interceptors.request.use(config => {
    const authStore = useAuthStore();

    // 🛑 CRÍTICO: SOLO AÑADIR EL TOKEN SI EXISTE
    if (authStore.token) {
        config.headers.Authorization = `Bearer ${authStore.token}`;
    }
    // Si la solicitud va al login, NO debe llevar token. La limpieza en el store ya se encarga,
    // pero esta es la forma en que Axios obtiene el token.

    return config;
});

// 2. Interceptor de Respuesta (Response Interceptor)
api.interceptors.response.use(
    response => response,
    error => {
        const authStore = useAuthStore();

        // 🚨 Manejo del 401 (Token Inválido)
        if (error.response && error.response.status === 401) {
            console.warn("Token de sesión expirado o inválido. Forzando cierre de sesión.");

            // 🛑 CRÍTICO: Usar la limpieza local para evitar llamadas anidadas.
            authStore.clearLocalState();

            // Redirigir al login si no estamos ya en él
            if (router.currentRoute.value.path !== '/login') {
                router.push('/login');
            }
        }
        return Promise.reject(error);
    }
);

export default api;*/
