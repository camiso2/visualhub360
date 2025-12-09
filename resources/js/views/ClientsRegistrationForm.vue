<template>
<ComponentRegisterClientForm v-if="clientNotFound && saleDataClient.client_document" @client-registered="onClientRegistered" />
    <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700 ">
        <ClientsView ref="ClientsViewRef" />
    </div>
</template>
<script setup>
import { reactive, ref, onMounted } from 'vue';
import ClientsView from './ClientsView.vue'; // Se mantiene la referencia a ClientsView
import ComponentRegisterClientForm from '../components/ComponentRegisterClientForm.vue';


const ClientsViewRef = ref(null);
const clientNotFound = ref(true);
const saleDataClient = ref({
    client_document: 1, // lo que escribe el usuario
    client_id: 1        // el valor real que usará el backend
});
const onClientRegistered = (payload) => {
    console.log('cliente registrado ::: ')
    if (payload.success) {
       // saleDataClient.value.client_document = payload.document_number;
        clientNotFound.value = true;
         if (ClientsViewRef.value && ClientsViewRef.value.fetchClients) { // Se cambia de fetchUsers a fetchClients (ajustar según el componente ClientsView)
            ClientsViewRef.value.fetchClients();
        }

    }
};
</script>

<style scoped>
/* Tu estilo Tailwind */
</style>
