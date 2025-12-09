<template>
  <div class="flex items-center justify-center h-screen bg-gray-100">
    <div class="text-center">
      <q-icon name="storefront" size="80px" color="grey-5" />
      <div class="text-h5 q-mt-md text-grey-9">Sucursal inactiva</div>
      <div class="text-grey-7 q-mt-sm">
        Contacta al administrador para reactivarla.
      </div>
      <q-btn
        label="Cerrar sesión"
        color="negative"
        class="q-mt-lg"
        @click="logout"
      />
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/useAuthStore';
import { useRouter } from 'vue-router';

const auth = useAuthStore();
const router = useRouter();

function logout() {
  auth.logout(); // limpia token y usuario
  router.replace({ name: 'Login' });
}
</script>
