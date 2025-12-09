import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '@/stores/useAuthStore'; // Asegúrate que esta ruta es correcta



// Importar Layouts y Vistas
import BranchBlockedView from '@/views/BranchBlockedView.vue';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import LoginView from '@/views/auth/LoginView.vue'; // Asume que tienes esta vista
import DashboardView from '@/views/DashboardView.vue';
import UsersView from '@/views/UsersView.vue';
import InventoriesView from '@/views/InventoriesView.vue';
import BranchesView from '../views/BranchesView.vue';
import ClientsView from '../views/ClientsView.vue';
import SalesView from '../views/SalesView.vue';
import SuppliersView from '../views/SuppliersView.vue';
import AccountsReceivableView from '../views/AccountsReceivableView.vue';
import CompanyRegistrationForm from '../views/auth/CompanyRegistrationForm.vue';
import SupplierRegistrationForm from '../views/SupplierRegistrationForm.vue';
import BranchRegistrationForm from '../views/BranchRegistrationForm.vue';
import UserRegistrationForm from '../views/UserRegistrationForm.vue';
import ClientsRegistrationForm from '../views/ClientsRegistrationForm.vue';
import InventoryRegistrationForm from '../views/InventoryRegistrationForm.vue';
/******** */
import DocumentsRoot from '../components/modals/DocumentsRoot.vue';
import ClientDocumentFormModal from '../components/modals/ClientDocumentFormModal.vue';
import UpdateDataClientFormModal from '../components/modals/UpdateDataClientFormModal.vue';
import UpdateDataUserFormModal from '../components/modals/UpdateDataUserFormModal.vue';
import UpdateDataBranchFormModal from '../components/modals/UpdateDataBranchFormModal.vue';
import UpdateDataSupplierFormModal from '../components/modals/UpdateDataSupplierFormModal.vue';
import UpdateDataInventoryFormModal from '../components/modals/UpdateDataInventoryFormModal.vue';
import UpdateAccountPendingFormModal from '../components/modals/UpdateAccountPendingFormModal.vue';
import AnulateSaleFormModal from '../components/modals/AnulateSaleFormModal.vue';

import DocumentsClient from '../views/DocumentsClient.vue';



import SaleRegistrationForm from '../views/SaleRegistrationForm.vue';
import UserPermissionsView from '../views/UserPermissionsView.vue';





const router = createRouter({
    // Usa el modo history (URL limpias)
    history: createWebHistory(import.meta.env.BASE_URL),

    routes: [
        {
            path: '/login',
            name: 'Login',
            component: LoginView,
            meta: { requiresAuth: false }
        },

        {
            path: '/registerCompany', // Puedes elegir la URL que desees
            name: 'RegisterCompany',
            component: CompanyRegistrationForm,
            // CRÍTICO: No requiere autenticación, por lo que no lleva meta: { requiresAuth: true }
            meta: { requiresAuth: false }
        },

        {
            path: '/',
            component: DashboardLayout,
            meta: { requiresAuth: true }, // Las rutas hijas requieren autenticación por defecto
            children: [
                {
                    path: '', // Ruta base /
                    name: 'Dashboard',
                    component: DashboardView
                },
                {
                    path: 'users', // Ruta completa /users
                    name: 'Users',
                    component: UsersView
                },
                {
                    path: '/sucursals',
                    name: 'Branches',
                    component: BranchesView,
                    meta: { requiresAuth: true }
                },
                {
                    path: '/clients',
                    name: 'Clients',
                    component: ClientsView,
                    meta: { requiresAuth: true }
                },
                {
                    path: '/BranchRegistration',
                    name: 'BranchRegistration',
                    component: BranchRegistrationForm,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                },
                {
                    path: '/UserRegistration',
                    name: 'UserRegistration',
                    component: UserRegistrationForm,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                },
                {
                    path: '/Suppliers',
                    name: 'Suppliers',
                    component: SuppliersView,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                }, {
                    path: '/Suppliers',
                    name: 'Suppliers',
                    component: SuppliersView,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                }, {
                    path: '/UserPermissions',
                    name: 'UserPermissions',
                    component: UserPermissionsView,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                }, {
                    path: '/Sales',
                    name: 'Sales',
                    component: SalesView,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                }, {
                    path: '/AccountsReceivable',
                    name: 'AccountsReceivable',
                    component: AccountsReceivableView,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                }, {
                    path: '/DocumentsRoot/:id',
                    name: 'DocumentsRoot',
                    component: DocumentsRoot,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                }, {
                    path: '/DocumentsClient/:id',
                    name: 'DocumentsClient',
                    component: DocumentsClient,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                }, {
                    path: '/ClientDocumentFormModal',
                    name: 'ClientDocumentFormModal',
                    component: ClientDocumentFormModal,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                }, {
                    path: '/UpdateDataClientFormModal',
                    name: 'UpdateDataClientFormModal',
                    component: UpdateDataClientFormModal,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                },{
                    path: '/AnulateSaleFormModal',
                    name: 'AnulateSaleFormModal',
                    component: AnulateSaleFormModal,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                }, {
                    path: '/UpdateDataSupplierFormModal',
                    name: 'UpdateDataSupplierFormModal',
                    component: UpdateDataSupplierFormModal,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                }, {
                    path: '/UpdateDataBranchFormModal',
                    name: 'UpdateDataBranchFormModal',
                    component: UpdateDataBranchFormModal,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                }, {
                    path: '/UpdateDataInventoryFormModal',
                    name: 'UpdateDataInventoryFormModal',
                    component: UpdateDataInventoryFormModal,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                }, {
                    path: '/UpdateDataUserFormModal',
                    name: 'UpdateDataUserFormModal',
                    component: UpdateDataUserFormModal,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                }, {
                    path: '/UpdateAccountPendingFormModal',
                    name: 'UpdateAccountPendingFormModal',
                    component: UpdateAccountPendingFormModal,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                },
                {
                    path: '/SupplierRegistration',
                    name: 'SupplierRegistration',
                    component: SupplierRegistrationForm,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                }, {
                    path: '/InventoriesBranch',
                    name: 'InventoriesBranch',
                    component: InventoriesView,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                }, {
                    path: '/ClientsRegistration',
                    name: 'ClientsRegistration',
                    component: ClientsRegistrationForm,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                }, {
                    path: '/InventoryRegistration',
                    name: 'InventoryRegistration',
                    component: InventoryRegistrationForm,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                }
                , {
                    path: '/SaleRegistration',
                    name: 'SaleRegistration',
                    component: SaleRegistrationForm,
                    meta: { requiresAuth: true } // Debe requerir autenticación
                }

            ]
        },
        {
            path: '/sucursal-bloqueada',
            name: 'BranchBlocked',
            component: BranchBlockedView,
            meta: { requiresAuth: false }
        },
        // Ruta Catch-all 404
        {
            path: '/:catchAll(.*)',
            name: 'NotFound',
            component: () => import('@/views/NotFoundView.vue') // Asume una vista 404
        }
    ]
});

// ------------------------------------------------------------------------
// 🛡️ GUARDIA DE NAVEGACIÓN (Corregida: ASÍNCRONA y solo un next())
// ------------------------------------------------------------------------

router.beforeEach(async (to, from, next) => { // ⬅️ DEBE SER ASÍNCRONO
    const auth = useAuthStore();
    const requiresAuth = to.meta.requiresAuth;

    // 1. Si hay un token guardado (gracias a Pinia Persist)
    if (auth.token) {
        // 🚨 Valida el token antes de continuar
        try {
            // Esto llama a /me. Si falla (token expirado), llama a logout().
            await auth.fetchUser();
        } catch (e) {
            // El error fue manejado por fetchUser (llamó a logout).
        }
    }

    // 2. Lógica de Redirección (Comprueba el estado final de auth.token)

    if (requiresAuth && !auth.token) {
        // No hay token o el token falló la validación (401).
        next({ name: 'Login' });
    } else if (auth.token && to.name === 'Login') {
        // Autenticado y tratando de ir a Login.
        next({ name: 'Dashboard' });
    } else {
        // Continuar (token válido o ruta pública).
        next();
    }
});

export default router;
