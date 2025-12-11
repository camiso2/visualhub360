<template>
    <div class="space-y-6">
        <!-- Información General del Cliente/Contexto
        <DataGeneral />-->


        <!-- Contenedor Principal -->
        <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">

            <HeaderButtonGenInformComplet :title="`Generar Ventas`" :isDopDownVisible=false>
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8.25v-2.5m0 0c0-.69-.56-1.25-1.25-1.25H6.25A1.25 1.25 0 005 4.75v14.5c0 .69.56 1.25 1.25 1.25h4.5c.69 0 1.25-.56 1.25-1.25v-2.5m0-12.5h3.5c.69 0 1.25.56 1.25 1.25v3.5m-4.75 7.25h6.5c.69 0 1.25-.56 1.25-1.25V9.75L15.5 6H12m0 8.25H9.75m2.25 3H9.75" />
                    </svg>

                </template>
            </HeaderButtonGenInformComplet>

            <!-- Mensajes / Alertas -->
            <div v-if="message" :class="messageClass"
                class="p-3 mb-1 ml-3 rounded-lg font-medium transition duration-300 col-span-full">
                {{ message }}
            </div>
            <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p>


            <div class="grid grid-cols-1 lg:grid-cols-[30%_69.3%] gap-6 p-2
            bg-white
            transition duration-300 hover:shadow-xl hover:border-indigo-200"> <!-- Título -->



                <!-- ===============================
            1. DETALLES GENERALES
            ================================== -->
                <section class="mb-6 p-4 border rounded-lg bg-indigo-50  space-y-4">
                    <h2 class="text-xl font-semibold text-indigo-600 mb-4">Detalles Generales </h2>


                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <div class="lg:col-span-3 space-y-4">

                            <div>
                                <label class="block text-sm font-medium text-gray-700">No. Factura (requerido)</label>
                                <input type="text" v-model="saleDataNumberInvoide.invoice_number" required
                                    @input="saleDataNumberInvoide.invoice_number = $getFormatInteger(saleDataNumberInvoide.invoice_number)"
                                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm p-2" />
                                <span
                                    class="bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300 px-3 py-1 text-xs font-semibold rounded-full w-fit">Última
                                    Factura en Sucursal N° : {{ lastInvoiceNumberUI }} </span>

                            </div>

                            <!-- INPUT DOCUMENTO -->
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700">
                                    Ingrese N° identificación del Cliente
                                </label>
                                <div class="flex gap-3 items-center">
                                    <input type="text" v-model.number="saleDataClient.client_document"
                                        @input="saleDataClient.client_document = $getFormatInteger($event.target.value)"
                                        @change="fetchClientByDocument" required
                                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm p-2" />

                                    <button @click="fetchClientByDocument" :disabled="isLoading" class="w-full gradient-button md:w-auto px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700
           disabled:bg-blue-300 transition flex items-center justify-center gap-2">

                                        <span v-if="isLoading" class="flex items-center gap-2">
                                            <svg v-if="!isLoading" class="animate-spin h-5 w-5 text-white"
                                                viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            <span>Buscando...</span>
                                        </span>

                                        <span v-else class="flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                                                </path>
                                            </svg>
                                            <span>Buscar</span>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <!-- MENSAJE DE ERROR -->
                            <p v-if="clientError" class="text-red-500 text-sm mb-2">
                                {{ clientError }}
                            </p>

                            <!-- BOTÓN CREAR CLIENTE SOLO SI NO EXISTE
                        <button v-if="clientNotFound && saleDataClient.client_document" @click="createClientDirectly"
                            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                            Crear Cliente
                        </button>-->

                            <ComponentRegisterClientForm v-if="clientNotFound && saleDataClient.client_document"
                                @client-registered="onClientRegistered" />

                            <!-- CLIENTE ENCONTRADO -->
                            <div v-if="clientFound"
                                class="mt-0 p-4 border rounded-lg shadow-sm bg-green-50 border-green-300">
                                <div class="flex items-center mb-3">
                                    <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="text-green-700 font-semibold text-lg">Cliente encontrado</h3>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-700">
                                    <p><span class="font-semibold">Nombre:</span> {{ clientFound.name }}</p>
                                    <p><span class="font-semibold">Documento:</span> {{ clientFound.document_number }}
                                    </p>
                                    <p><span class="font-semibold">Teléfono:</span> {{ clientFound.phone }}</p>
                                    <p><span class="font-semibold">Email:</span> {{ clientFound.email }}</p>
                                    <p><span class="font-semibold">Ciudad:</span> {{ clientFound.city }}</p>
                                    <p><span class="font-semibold">Dirección:</span> {{ clientFound.address }}</p>
                                </div>
                            </div>
                            <div v-if="clientFound && clientFound.documents && clientFound.documents.length > 0"
                                class="mt-4 p-4 border rounded-lg shadow-sm bg-white">

                                <h4 class="text-gray-800 font-semibold text-md mb-2">
                                    Documentos del cliente ({{ filteredDocuments.length }})
                                </h4>

                                <!-- LISTA CON CHECKBOX -->
                                <ul v-if="!selectedDocumentId" class="space-y-2">
                                    <li v-for="doc in clientFound.documents" :key="doc.id"
                                        class="p-3 border rounded-lg bg-gray-50 flex items-start justify-between">

                                        <div>
                                           <!-- <p class="text-sm"><span class="font-semibold">ID:</span> {{ doc.id }}</p>-->
                                            <p><span class="font-semibold">Emisor Documento/s:</span> {{
                                                doc.name_company }}
                                            </p>
                                            <p class="text-sm"><span class="font-semibold">Descripción:</span> {{
                                                doc.description }}</p>

                                            <p class="text-sm"><span class="font-semibold">Fecha Creación:</span>
                                                {{ new Date(doc.created_at).toLocaleDateString('es-CO', {
                                                    year: 'numeric', month: '2-digit', day: '2-digit',
                                                    hour: '2-digit', minute: '2-digit'
                                                }) }}

                                            </p>
                                        </div>

                                        <!-- CHECKBOX (solo 1 seleccionado) -->
                                        <input type="checkbox" class="w-5 h-5 mt-2"
                                            :checked="selectedDocumentId === doc.id" @change="(e) => {
                                                if (e.target.checked) {
                                                    selectedDocumentId = doc.id;   // Guarda el documento seleccionado
                                                } else {
                                                    selectedDocumentId = null;     // Si se desmarca → mostrar todos
                                                }
                                            }" />
                                    </li>
                                </ul>




                                <!-- LISTA FILTRADA ABAJO -->
                                <div v-if="selectedDocumentId" class="mt-6 p-4 border rounded-lg shadow bg-green-50">
                                    <h4 class="text-gray-700 font-semibold mb-2">Documento seleccionado</h4>

                                    <!-- Solo el documento seleccionado -->
                                    <div v-for="doc in clientFound.documents.filter(d => d.id === selectedDocumentId)"
                                        :key="'selected-' + doc.id">

                                        <p><span class="font-semibold">ID:</span> {{ doc.id }}</p>
                                        <p><span class="font-semibold">Emisor Documento/s:</span> {{ doc.name_company }}
                                        </p>
                                        <p><span class="font-semibold">Descripción:</span> {{ doc.description }}</p>

                                        <p><span class="font-semibold">Fecha:</span> {{ doc.created_at }}</p>

                                        <!-- Botón para volver a ver todos -->
                                        <button class="mt-3 px-3 py-1 bg-gray-700 text-white rounded"
                                            @click="selectedDocumentId = null">
                                            Ver todos los documentos
                                        </button>

                                    </div>
                                </div>

                            </div>
                            <!-- SI NO HAY DOCUMENTOS Y selectedDocumentId es null → MOSTRAR BOTÓN -->
                            <div v-if="clientFound && clientFound.documents && clientFound.documents.length === 0"
                                class="mt-4 p-4 border rounded-lg shadow-sm bg-white">

                                <p class="text-gray-700 mb-3">Este cliente no tiene documentos registrados.</p>

                                <button @click="openModal(clientFound.id)"
                                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                                    Registrar documento al cliente
                                </button>
                            </div>
                        </div>
                    </div>

                </section>
                <section class="mb-6 p-3  border rounded-lg bg-indigo-50 space-y-4">
                    <div class="p-6 bg-white shadow-lg rounded-lg">
                        <h2 class="text-xl font-semibold mb-4 text-gray-800">Buscar Inventario por SKU</h2>
                        <form @submit.prevent="searchBySku" class="flex flex-col md:flex-row gap-3 md:gap-4 mb-6">
                            <input v-model="skuInput" @input="skuInput = $getFormatInteger($event.target.value)"
                                type="text" placeholder="Introduce el SKU del producto" required
                                class="w-full md:flex-grow p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" />

                            <button type="submit" :disabled="isLoading" class="w-full gradient-button md:w-auto px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700
           disabled:bg-blue-300 transition flex items-center justify-center gap-2">

                                <span v-if="isLoading" class="flex items-center gap-2">
                                    <svg v-if="!isLoading" class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4">
                                        </circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    <span>Buscando...</span>
                                </span>

                                <span v-else class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                                        </path>
                                    </svg>
                                    <span>Buscar</span>
                                </span>
                            </button>
                        </form>
                        <div v-if="messageInventory"
                            class="p-3 mb-4 rounded-lg font-medium transition duration-300 col-span-full" :class="{
                                // 🟢 ESTILO DE ÉXITO (Si se encontró un producto)
                                'bg-green-100 text-green-800 border border-green-400': inventory,

                                // 🔴 ESTILO de ERROR/ADVERTENCIA (Si no se encontró o hubo un error)
                                'bg-red-100 text-red-800 border border-red-400': !inventory
                            }">
                            {{ messageInventory }}
                        </div>
                        <div v-if="inventory" class="border p-4 rounded-lg bg-gray-50">
                            <h3 class="text-lg font-bold mb-3 text-gray-800">{{ inventory.name }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-md font-semibold mb-2 text-gray-700">📦 Información del Producto
                                    </h4>
                                    <div class="space-y-1 text-sm">
                                        <p><strong>SKU:</strong> {{ inventory.sku }}</p>
                                        <p><strong>Stock Actual:</strong> {{ inventory.quantity }}</p>
                                        <p><strong>Precio de Venta:</strong> ${{ inventory.sale_price }}</p>
                                    </div>
                                </div>
                                <div v-if="inventory.supplier">
                                    <h4 class="text-md font-semibold mb-2 text-gray-700">👤 Detalles del Proveedor</h4>
                                    <div class="space-y-1 text-sm">
                                        <p><strong>Nombre:</strong> {{ inventory.supplier?.name ?? 'Sin Proveedor' }}
                                        </p>
                                        <p><strong>Email:</strong> {{ inventory.supplier?.email ?? 'Sin Email' }}</p>
                                        <p><strong>Teléfono:</strong> {{ inventory.supplier?.phone ?? 'Sin Télefono' }}
                                        </p>
                                    </div>
                                </div>
                                <div v-else
                                    class="p-4 rounded-lg bg-yellow-50 border border-yellow-300 flex items-center space-x-3 w-full">

                                    <svg class="h-6 w-6 text-yellow-500 flex-shrink-0" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.328a9 9 0 013.486 0 9.001 9.001 0 013.486 0L17.5 5.5v9l-2.257 2.172a9 9 0 00-3.486 0 9.001 9.001 0 00-3.486 0L2.5 14.5v-9l2.257-2.172zM10 13a1 1 0 100 2 1 1 0 000-2zm0-8a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>

                                    <p class="text-sm font-medium text-yellow-800">
                                        **Información Faltante:** El producto no tiene asignado un proveedor.
                                    </p>
                                </div>
                            </div>
                            <div
                                class="mt-6 pt-4 border-t border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                <div class="md:col-span-1">
                                    <button @click="addProductToSale(inventory)" :disabled="!paymentProviderList.length"
                                        class="w-full px-5 py-2 bg-green-600 text-white font-semibold rounded-lg
           hover:bg-green-700 transition duration-150 shadow-md
           flex items-center justify-center gap-2 disabled:bg-gray-400 gradient-button">

                                        <span class="flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>

                                            <span>Agregar Producto</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="saleItems.length > 0"
                        class="mt-8 p-6 border-2 border-dashed border-blue-300 rounded-lg bg-blue-50">
                        <h3 class="text-xl font-bold mb-4 text-blue-800 coompany-title-color">Productos agregados en la
                            Venta ({{
                                saleItems.length
                            }})</h3>

                        <div class="min-w-full">
                            <div
                                class="hidden md:grid grid-cols-12 px-4 py-2 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-300 sticky top-0 z-10 rounded-t-lg shadow-sm">
                                <div class="flex items-center col-span-3 font-bold">
                                    <span>Producto</span>
                                </div>

                                <div class="flex items-center col-span-1 justify-end font-bold">
                                    <span>Precio</span>
                                </div>

                                <div class="flex items-center col-span-1 justify-center font-bold">
                                    <span>Cant.</span>
                                </div>

                                <div class="flex items-center col-span-1 justify-center font-bold">
                                    <span>Desc. (%)</span>
                                </div>

                                <div class="flex items-center col-span-1 justify-center font-bold">
                                    <span>Desc Max (%)</span>
                                </div>

                                <div class="flex items-center col-span-1 justify-center font-bold">
                                    <span>IVA (%)</span>
                                </div>

                                <div class="flex items-center col-span-1 font-bold">
                                    <span>Pago</span>
                                </div>

                                <div class="flex items-center col-span-1 justify-end font-bold">
                                    <span>Desc Tot.</span>
                                </div>

                                <div class="flex items-center col-span-1 justify-end font-bold">
                                    <span>Sub Total</span>
                                </div>

                                <div class="flex items-center justify-center col-span-1" title="Quitar Producto">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m4 0h-4" />
                                    </svg>
                                </div>
                            </div>

                            <div class="divide-y divide-gray-200 bg-white">
                                <div v-for="(item, index) in saleItems" :key="index"
                                    class="grid grid-cols-1 md:grid-cols-12 px-4 py-3 text-sm border-b border-gray-100 hover:bg-gray-50 transition-all duration-150">

                                    <div
                                        class="col-span-1 md:col-span-3 py-1 flex justify-between items-center w-full order-1">
                                        <div class="font-medium text-gray-900 truncate">
                                            <span class="md:hidden text-gray-500 text-xs font-semibold">Producto:
                                            </span>
                                            {{ item.name }}
                                        </div>
                                        <button @click="removeItemFromSale(item.inventory_id)"
                                            class="md:hidden text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-50"
                                            title="Eliminar ítem">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m4 0h-4">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>

                                    <div
                                        class="col-span-1 md:col-span-1 py-1 flex justify-between md:justify-end items-center text-gray-600 order-3">
                                        <span class="md:hidden text-gray-500 text-xs font-semibold">Precio</span>
                                        <span>${{ item.sale_price.toLocaleString('es-CO') }}</span>
                                    </div>

                                    <div
                                        class="col-span-1 md:col-span-1 py-1 flex justify-between md:justify-center items-center order-4">
                                        <span class="md:hidden text-gray-500 text-xs font-semibold">Cantidad</span>
                                        <input type="number" v-model.number="item.quantity"
                                            @input="item.quantity = $getFormatInteger($event.target.value)" min="1"
                                            class="md:w-full w-1/2 border border-gray-300 rounded text-center text-sm p-1 focus:border-indigo-500 max-w-[80px]">
                                    </div>

                                    <div
                                        class="col-span-1 md:col-span-1 py-1 flex justify-between md:justify-center items-center order-5">
                                        <span class="md:hidden text-gray-500 text-xs font-semibold">Desc. (%)</span>
                                        <input type="text" v-model.number="item.discount_percentage"
                                            @input="item.discount_percentage = $getFormatInteger($event.target.value)"
                                            min="0" :max="item.max_disscount" placeholder="0"
                                            class="md:w-full w-1/2 border border-gray-300 rounded text-center text-sm p-1 focus:border-indigo-500 max-w-[80px]">
                                    </div>

                                    <div
                                        class="col-span-1 md:col-span-1 py-1 flex justify-between md:justify-center items-center order-6">

                                        <span class="md:hidden text-gray-500 text-xs font-semibold">Desc Max (%)</span>

                                        <input type="text"
                                            :value="item.max_disscount ? item.max_disscount + '%' : 'N/A'" disabled
                                            class="md:w-full w-1/2 border border-gray-300 rounded text-center text-sm p-1 focus:border-indigo-500 max-w-[80px] bg-gray-100 disabled:bg-gray-100 text-gray-600 font-medium">
                                    </div>

                                    <div
                                        class="col-span-1 md:col-span-1 py-1 flex justify-between md:justify-center items-center order-6">
                                        <span class="md:hidden text-gray-500 text-xs font-semibold">IVA (%)</span>
                                        <input type="number" v-model.number="item.tax_sale" min="0" max="100"
                                            class="md:w-full w-1/2 border border-gray-300 rounded text-center text-sm p-1 focus:border-indigo-500 max-w-[80px] bg-gray-100 disabled:bg-gray-100 text-gray-600 font-medium"
                                            disabled>
                                    </div>

                                    <div
                                        class="col-span-1 md:col-span-1 py-1 flex flex-col md:flex-row order-7 relative">
                                        <span class="md:hidden text-gray-500 text-xs font-semibold mb-1">Pago</span>

                                        <select v-model="item.payment_provider_id" required class="w-full appearance-none rounded-lg border border-gray-400 shadow-sm
               py-1.5 pl-2 pr-8 text-sm text-gray-700 bg-white
               focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/50 transition duration-150">

                                            <option v-for="provider in paymentProviderList" :key="provider.id"
                                                :value="provider.id">
                                                {{ provider.name }}
                                            </option>
                                        </select>

                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 top-0 flex items-center px-2 md:mt-0 mt-5">
                                            <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>

                                    <div
                                        class="col-span-1 md:col-span-1 py-1 flex justify-between md:justify-end items-center text-red-600 order-8">
                                        <span class="md:hidden text-gray-500 text-xs font-semibold">Desc Tot.</span>
                                        <span>-${{ calculateItemDiscountAmount(item).toLocaleString('es-CO') }}</span>
                                    </div>

                                    <div
                                        class="col-span-1 md:col-span-1 py-1 flex justify-between md:justify-end items-center order-9">

                                        <span class="md:hidden text-gray-700 text-sm font-bold">SUB TOTAL:</span>

                                        <span
                                            class="text-lg md:text-base font-extrabold text-green-600 md:text-green-600">
                                            ${{ calculateItemLineTotal(item).toLocaleString('es-CO') }}
                                        </span>
                                    </div>

                                    <div class="hidden md:flex items-center justify-center col-span-1 py-1 order-10">
                                        <button @click="removeItemFromSale(item.inventory_id)"
                                            class="text-red-500 hover:text-red-700 transition duration-150 p-1 rounded-full hover:bg-red-50"
                                            title="Eliminar ítem">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m4 0h-4">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>

                                </div>
                            </div>

                            <div class="w-full bg-gray-100 border-t-2 border-gray-400 p-4 rounded-b-lg">
                                <div class="grid grid-cols-2 gap-2 md:grid-cols-11 md:gap-0">

                                    <div
                                        class="col-span-1 md:col-span-10 text-right text-sm font-semibold text-gray-700 py-1">
                                        Desc. Total
                                    </div>
                                    <div
                                        class="col-span-1 md:col-span-1 text-right text-sm font-bold text-red-700 py-1">
                                        -${{ totalDiscount.toLocaleString('es-CO') }}
                                    </div>

                                    <div
                                        class="col-span-1 md:col-span-10 text-right text-sm font-semibold text-gray-700 py-1  border-gray-300">
                                        Neto Total
                                    </div>
                                    <div
                                        class="col-span-1 md:col-span-1 text-right text-sm font-bold text-blue-700 py-1  border-gray-300">
                                        ${{ totalNetPrice.toLocaleString('es-CO') }}
                                    </div>

                                    <div
                                        class="col-span-1 md:col-span-10 text-right text-sm font-semibold text-gray-700 py-1">
                                        IVA Total
                                    </div>
                                    <div
                                        class="col-span-1 md:col-span-1 text-right text-sm font-bold text-yellow-700 py-1">
                                        ${{ totalTax.toLocaleString('es-CO') }}
                                    </div>

                                    <div
                                        class="col-span-1 md:col-span-10 text-right text-base font-extrabold text-blue-800 pt-3 border-t border-gray-300 coompany-title-color">
                                        TOTAL
                                    </div>


                                    <div
                                        class="col-span-1 md:col-span-1 text-right text-base font-extrabold text-green-600 pt-3 border-t border-gray-300 md:text-green-600">
                                        ${{ grandTotal.toLocaleString('es-CO') }}
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                    <div class="pt-4 border-t col-span-full">
                        <button @click="submitSale" :disabled="isLoading || !isSaleValid" :class="{
                            // ... (Tu lógica de clases Tailwind aquí, preferiblemente Opción B para simplicidad) ...
                        }" class="w-full gradient-button py-3 px-4 rounded-md shadow-sm text-lg font-bold text-white
    bg-green-600 hover:bg-green-700 transition disabled:opacity-50 disabled:cursor-not-allowed
    flex items-center justify-center gap-2">

                            <svg v-if="!isLoading && isSaleValid" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>

                            {{
                                isLoading
                                    ? 'Procesando Venta...'
                                    : isSaleValid
                                        ? 'Registrar Venta'
                                        : 'Debe ingresar todos los datos para registrar la venta'
                            }}
                        </button>
                    </div>
                </section>

            </div>

            <ClientDocumentFormModal v-model="isModalOpen" :client-id="selectedClientId"
                @documentSaved="handleDocumentSaved" />


            <InventoriesView ref="InventoriesViewRef" @last-number-received="handleLastNumber" />


        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import DataGeneral from '../components/DataGeneral.vue';
import ComponentRegisterClientForm from '../components/ComponentRegisterClientForm.vue';
import HeaderButtonGenInformComplet from '../components/HeaderButtonGenInformComplet.vue'
import { getErrorMessage } from "@/utils/errorHelper";
import api from "@/plugins/axios";
import InventoriesView from './InventoriesView.vue';



import ClientDocumentFormModal from '@/components/modals/ClientDocumentFormModal.vue';

import { useAuthStore } from '@/stores/useAuthStore'; // <-- ¡IMPORTA desde el archivo externo!

const authStore = useAuthStore();




const InventoriesViewRef = ref(null);
const loading = ref(true);


const isModalOpen = ref(false);
const selectedClientId = ref(null);
// Función para abrir la modal con el ID del cliente
const openModal = (clientId) => {


    // 1. Limpiar los campos y el archivo cada vez que abres el modal
    selectedClientId.value = clientId;
    isModalOpen.value = true;
    //el array de archivos cada vez que abres el modal
    console.log('ID recibido y asignado:', selectedClientId.value); // <-- ¡Verifica aquí!

}
// Función que se ejecuta cuando el componente hijo termina de guardar el documento
const handleDocumentSaved = () => {
    // Aquí puedes recargar la lista de documentos del cliente o mostrar una notificación.
    console.log('Documento guardado. Recargar la lista de documentos.');
    fetchClientByDocument();
    // recargarListaDeDocumentos();
}






// ============================================================
// 1. DEFINICIONES BASE (ref)
// ============================================================

// Define las propiedades de la respuesta o deja en null inicialmente
const inventory = ref(null);
const isLoadingInventory = ref(false);
const skuInput = ref('');
const messageInventory = ref('');
const saleItems = ref([]); // Lista de productos que se agregarán a la venta

//VENTAS
const isLoading = ref(false);
const message = ref('');
const isError = ref(false);
const selectedDocumentId = ref(null);
const errorMessage = ref('');
const clientFound = ref(null);
const clientError = ref(null);
const clientNotFound = ref(false);

const saleDataNumberInvoide = ref({
    invoice_number: null,
});

/* BUSCAR CLIENTE */
const saleDataClient = ref({
    client_document: null, // lo que escribe el usuario
    client_id: null        // el valor real que usará el backend
});

const paymentProviderList = ref([]);
const lastInvoiceNumber = ref(null);
const lastInvoiceNumberUI = ref(null);
const handleLastNumber = (payload) => {
    const receivedLastNumber = payload.lastNumber;
    lastInvoiceNumberUI.value = receivedLastNumber;
};


// ============================================================
// 2. FUNCIONES DE CÁLCULO DE LÍNEA (MOVIMIENTO HACIA ARRIBA)
// ============================================================

/**
 * Calcula el monto del descuento para un ítem de venta.
 */
const calculateItemDiscountAmount = (item) => {
    // 1. Saneamiento de datos
    // 🌟 CORRECCIÓN: Usar net_price como la base imponible
    const netPrice = parseFloat(item.net_price) || 0;
    const quantity = parseFloat(item.quantity) || 0;
    const discountPercentage = parseFloat(item.discount_percentage) || 0;

    if (netPrice <= 0 || quantity <= 0 || discountPercentage <= 0) {
        return 0; // No hay precio, cantidad o descuento
    }

    // 2. Calcular el precio base Neto (Precio Unitario Neto * Cantidad)
    const basePriceNet = netPrice * quantity; // Base imponible ANTES de descuento

    // 3. Calcular el monto del descuento
    const discountRate = discountPercentage / 100;
    const discountAmount = basePriceNet * discountRate;

    // 4. Devolver el monto del descuento (a 2 decimales)
    return parseFloat(discountAmount.toFixed(2));
};

const totalNetPrice = computed(() => {
    // Suma el precio neto (después de descuento, antes de IVA) de cada ítem.
    return saleItems.value.reduce((total, item) => {

        // 1. Obtener el precio neto UNITARIO y la cantidad
        const netPriceUnit = parseFloat(item.net_price) || 0;
        const quantity = parseFloat(item.quantity) || 0;
        const discountPercentage = parseFloat(item.discount_percentage) || 0;

        // 2. Calcular el total neto antes de descuento
        const lineNetPrice = netPriceUnit * quantity;

        // 3. Aplicar descuento al precio neto
        const discountAmount = lineNetPrice * (discountPercentage / 100);

        // 4. Sumar la Base Imponible al total general
        return total + (lineNetPrice - discountAmount);
    }, 0);
});

/**
 * Calcula el monto del impuesto (IVA) para un ítem de venta.
 */
const calculateItemTaxAmount = (item) => {
    // 1. Obtener valores necesarios
    const netPrice = parseFloat(item.net_price) || 0; // <-- Usamos net_price como base
    const quantity = parseFloat(item.quantity) || 0;
    const discountPercentage = parseFloat(item.discount_percentage) || 0;
    const taxSale = parseFloat(item.tax_sale) || 0; // Porcentaje de IVA (ej: 19)

    // Validación inicial
    if (netPrice <= 0 || quantity <= 0 || taxSale <= 0) {
        return 0;
    }

    // 2. Calcular el Subtotal Neto (Net Price * Cantidad)
    const basePriceNet = netPrice * quantity;

    // 3. Calcular la Base Imponible después de aplicar el Descuento
    // IMPORTANTE: Generalmente, el descuento se aplica al precio neto.
    const discountFactor = discountPercentage / 100;
    const discountAmount = basePriceNet * discountFactor;

    // Esta es la Base Imponible final (Precio Neto * Cantidad - Descuento)
    const basePriceAfterDiscount = basePriceNet - discountAmount;

    // 4. Calcular el Monto del Impuesto (IVA)
    const taxRate = taxSale / 100;
    const taxAmount = basePriceAfterDiscount * taxRate;

    // console.log('Monto del impuesto (Base Imponible) ::: ' + basePriceAfterDiscount);

    // Devolvemos el monto del impuesto redondeado
    return parseFloat(taxAmount.toFixed(2));
};


/**
 * Calcula el Total de la Línea (Precio Base - Descuento + IVA).
 */
const calculateItemLineTotal = (item) => {
    // 1. Obtener los valores base (saneados)
    // 🌟 CORRECCIÓN 1: Usar el PRECIO NETO (item.net_price) como base unitaria
    const netPriceUnit = parseFloat(item.net_price) || 0;
    const quantity = parseFloat(item.quantity) || 0;

    // Si no hay precio o cantidad, el total es 0
    if (netPriceUnit <= 0 || quantity <= 0) {
        return 0;
    }

    // 2. Calcular el Precio Neto Total ANTES de descuento
    const basePriceNet = netPriceUnit * quantity;

    // 3. Obtener el MONTO DEL DESCUENTO
    // NOTA: Asume que calculateItemDiscountAmount usa item.net_price internamente
    const discountAmount = calculateItemDiscountAmount(item);

    // Base Imponible: Neto - Descuento
    const basePriceAfterDiscount = basePriceNet - discountAmount;

    // 4. Obtener el MONTO DEL IVA
    // 🌟 CORRECCIÓN 2: Descomentar y usar el cálculo real del IVA
    const taxAmount = calculateItemTaxAmount(item);

    // 5. Calcular el Total Final de la Línea
    // (Base Imponible) + IVA
    const lineTotal = basePriceAfterDiscount + taxAmount;

    // Devolvemos el resultado redondeado a 2 decimales
    return parseFloat(lineTotal.toFixed(2));
};


// ============================================================
// 3. PROPIEDADES CALCULADAS DE TOTALES (NUEVAS Y MOVIDAS ARRIBA)
// ============================================================

/**
 * Calcula la suma de los montos de descuento de todos los ítems.
 */
const totalDiscount = computed(() => {
    return saleItems.value.reduce((sum, item) => {
        return sum + calculateItemDiscountAmount(item);
    }, 0);
});

/**
 * Calcula la suma de los montos de IVA de todos los ítems.
 */
const totalTax = computed(() => {
    return saleItems.value.reduce((sum, item) => {
        return sum + calculateItemTaxAmount(item);
    }, 0);
});

/**
 * Calcula el Gran Total de la venta (suma de todos los totales de línea).
 */
const grandTotal = computed(() => {
    return saleItems.value.reduce((sum, item) => {
        return sum + calculateItemLineTotal(item);
    }, 0);
});

/* ============================================================
   VALIDACIÓN GENERAL DE VENTA (EXISTENTE)
============================================================ */
const isSaleValid = computed(() => {
    // 1. Debe haber un cliente seleccionado (client_id no nulo)
    const hasClient = !!saleDataClient.value.client_id;

    // 2. Debe haber al menos un ítem en el carrito
    const hasItems = saleItems.value.length > 0;

    // 3. Todos los ítems deben tener un proveedor de pago seleccionado (payment_provider_id)
    const itemsAreValid = saleItems.value.every(item => !!item.payment_provider_id);

    // Opcional: Podrías añadir validaciones extra, como:
    // const quantitiesAreValid = saleItems.value.every(item => item.quantity > 0);

    // Retorna TRUE solo si todas las condiciones son TRUE
    return hasClient && hasItems && itemsAreValid;
});

/* ============================================================
   UI HELPERS (EXISTENTE)
============================================================ */
const messageClass = computed(() =>
    isError.value
        ? 'bg-red-100 border-red-400 text-red-700'
        : 'bg-green-100 border-green-400 text-green-700'
);
/**
 * Agrega el producto encontrado al array saleItems (el carrito de venta),
 * estableciendo el primer proveedor de la lista como el valor por defecto.
 * @param {Object} product El objeto de inventario completo (inventory)
 */
const addProductToSale = (product) => {
    // 1. Determinar el proveedor por defecto (El primero, que es "Efectivo")
    const defaultProvider = paymentProviderList.value.length > 0
        ? paymentProviderList.value[0]
        : { id: null, name: 'Efectivo' }; // Fallback si la lista está vacía
    const defaultProviderId = defaultProvider.id;
    const defaultPaymentMethodName = defaultProvider.name; // ✅ CLAVE: Obtenemos el nombre
    // 2. Verificar si el producto ya está en el carrito
    const existingItem = saleItems.value.find(item => item.inventory_id === product.id);
    if (existingItem) {
        existingItem.quantity += 1;
        // Opcional: Si el usuario quiere mantener la consistencia, podríamos resetear el método de pago al default
        // existingItem.payment_provider_id = defaultProviderId;
        // existingItem.payment_method = defaultPaymentMethodName;
        messageInventory.value = `Cantidad de ${product.name} aumentada a ${existingItem.quantity}.`;
    } else {
        const newItem = {
            inventory_id: product.id,
            quantity: 1,
            //discount_percentage: parseFloat(product.max_disscount) || 0,
            discount_percentage: 0, // <-- Asegúrate de que se inicialice en CERO
            max_disscount: inventory.max_disscount || 0,
            // ✅ Guardamos el ID del proveedor (dato para la API)
            payment_provider_id: defaultProviderId,
            // ✅ Guardamos el Nombre del método de pago (dato para la UI del carrito)
            payment_method: defaultPaymentMethodName,

            //Asignar el valor del inventario al ítem
            max_disscount: product.max_disscount || 0,


            // Datos de visualización
            name: product.name,
            sku: product.sku,
            sale_price: parseFloat(product.sale_price) || 0,
            tax_sale: (parseFloat(product.tax_sale) || 0),
            net_price: parseFloat(product.net_price || 0),
        };
        saleItems.value.push(newItem);

        console.log('TODOS ::: , ', saleItems.value)
        messageInventory.value = `Producto (${product.name}), agregado al con éxito.`;
        console.log('valor de false/true ::: , ', messageInventory.value)
    }
    //Limpiar estado de búsqueda
    inventory.value = null;
    skuInput.value = '';
};

/**
 * Realiza la búsqueda del producto por SKU a través de la API.
 */
const searchBySku = async () => {
    authStore.loading = true;
    // 1. Validar el input
    if (!skuInput.value.trim()) {
        messageInventory.value = 'Por favor, introduce el SKU para buscar.';
        inventory.value = null;
        return;
    }
    isLoadingInventory.value = true;
    messageInventory.value = '';
    inventory.value = null;
    try {
        console.log('valor a enviar  :: ' + skuInput.value.trim())
        // USO DIRECTO DE LA INSTANCIA DE AXIOS IMPORTADA
        const response = await api.post('/inventory/searchBySku', {
            sku: String(skuInput.value.trim())
        });
        console.log('valor a recibido  :: ', response.data)
        // 2. Procesar la respuesta de la API (código 201)
        if (response.data && response.data.success) {

            if (InventoriesViewRef.value) {
                InventoriesViewRef.value.fetchInventories(); // Esto probablemente debería ser fetchProducts
            }

            const fetchedInventory = response.data.data.inventory;
            if (fetchedInventory) {
                // Producto encontrado (con el proveedor incluido)
                inventory.value = fetchedInventory;
                messageInventory.value = response.data.message;
                // Guardar la lista de proveedores globalmente
                if (fetchedInventory.paymentProviders) {
                    paymentProviderList.value = fetchedInventory.paymentProviders;
                }
            } else {
                // Producto no encontrado
                messageInventory.value = response.data.message || 'Producto no encontrado en el inventario.';
            }
        } else {
            // Manejar errores de la API si 'success' es false
            messageInventory.value = response.data.message || 'Ocurrió un error al procesar la búsqueda.';
        }
        authStore.loading = false;
    } catch (error) {
        // Manejar errores de red o errores HTTP (422, 500, etc.)
        console.error('Error durante la búsqueda:', error);
        // Manejo de error 422 (Validación )
        if (error.response && error.response.status === 422) {
            messageInventory.value = 'Error de validación: El SKU proporcionado no es válido.';
        } else {
            messageInventory.value = 'Error de conexión o servidor al buscar el producto.';
        }
    } finally {
        isLoadingInventory.value = false;

    }
};

/**
 * Obtiene el nombre del proveedor de manera segura.
 */
const getSupplierName = () => {
    if (inventory.value && inventory.value.supplier) {
        return inventory.value.supplier.name;
    }
    return 'N/A';
};
const filteredDocuments = computed(() => {
    if (!selectedDocumentId.value) {
        return clientFound.value.documents;
    }
    return clientFound.value.documents.filter(doc => doc.id === selectedDocumentId.value);
});
/*======================================================
 BUSCAR CLIENTE
 ======================================================*/
const onClientRegistered = (payload) => {
    if (payload.success) {
        saleDataClient.value.client_document = payload.document_number;
        clientNotFound.value = false;
        fetchClientByDocument();
    }
};
const fetchClientByDocument = async () => {
    console.log('documento : ' + saleDataClient.value.client_document)

    authStore.loading = true;
    if (!saleDataClient.value.client_document) {
        clientError.value = "Debe ingresar un documento válido";
        clientFound.value = null;
        clientNotFound.value = false;
        authStore.loading = false;
        return;
    }

    try {
        const response = await api.post("/clients/searchByDocument", {
            document_number: String(saleDataClient.value.client_document)
        });

        const data = response.data;
        console.log('datos del cliente :: ', data.data)

        if (data.success && data.data.client) {
            clientFound.value = data.data.client;
            saleDataClient.value.client_id = data.data.client.id;
            clientError.value = null;
            clientNotFound.value = false;
        } else {
            clientFound.value = null;
            saleDataClient.value.client_id = null;
            clientNotFound.value = true;   // ostrar botón
            clientError.value = "Cliente no encontrado, por Favor registrelo !";
        }

        authStore.loading = false;

    } catch (error) {
        clientFound.value = null;
        saleDataClient.value.client_id = null;
        clientNotFound.value = false;
        clientError.value = "Error consultando cliente";
        console.error(error);
        authStore.loading = false;
    }
};

async function downloadInvoice(url) {
    try {
        const link = document.createElement('a');
        link.href = url;              // aquí usas el parámetro correcto
        link.download = '';           // permite usar el nombre original del PDF
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } catch (error) {
        console.error("Error descargando la factura:", error);
    }
}

/* ============================================================
   SUBMIT VENTA
============================================================ */

const submitSale = async () => {
    authStore.loading = true;
    console.log('id de documento : :', selectedDocumentId.value)
    console.log('id de cliente : :', saleDataClient.value.client_id)
    console.log('N° invoice : :', saleDataNumberInvoide.value.invoice_number)
    console.log('json a enviar :: ', saleItems.value)
    console.log('TODOS LOS PRODUCTOS ::: ', saleItems.value)
    lastInvoiceNumberUI.value = saleDataNumberInvoide.value.invoice_number;

    if (isLoading.value) return;

    if (!saleDataClient.value.client_id) {
        isError.value = true;
        message.value = 'El ID del Cliente es obligatorio.';
        return setTimeout(() => (message.value = ''), 5000);
    }

    // ✅ VALIDAR QUE HAYA PRODUCTOS EN EL CARRITO
    if (saleItems.value.length === 0) {
        isError.value = true;
        message.value = 'Debe agregar al menos un producto a la venta.';
        return setTimeout(() => (message.value = ''), 5000);
    }

    const payload = {
        client_id: saleDataClient.value.client_id,
        document_id: selectedDocumentId.value ?? null,
        invoice_number: saleDataNumberInvoide.value.invoice_number || null,
        items: saleItems.value.map(item => { // <-- INICIO de la función de bloque (con llaves)

            // 1. BÚSQUEDA DEL PROVEEDOR (aquí es donde usas 'const')
            const selectedProvider = paymentProviderList.value.find(
                p => p.id === item.payment_provider_id
            );

            // 2. DEVOLVER EXPLÍCITAMENTE EL NUEVO OBJETO ÍTEM
            return { // <-- ¡ESTE 'return' es obligatorio!
                inventory_id: item.inventory_id,
                quantity: item.quantity,
                discount_percentage: item.discount_percentage,

                payment_method: selectedProvider?.name || 'Método Desconocido',

                payment_provider_id: item.payment_provider_id


            };
        }) // <-- FIN del mapeo
    };

    try {
        isLoading.value = true;
        message.value = '';
        isError.value = false;

        const response = await api.post('/sales', payload);

        console.log("VENTA REGISTRADA", response.data.data);
        message.value = response.data.message || 'Venta realizada con éxito.';

        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Documento agregado con éxito!",
            showConfirmButton: false,
            timer: 1500
        });

        downloadInvoice(response.data.data.invoice_url);

        errorMessage.value = null;
        authStore.loading = false;

    } catch (error) {

        if (error.response) {
            // ERRORES 422 VALIDACIÓN
            if (error.response.status === 422) {
                const errors = error.response.data?.data?.errors
                    ?? error.response.data?.errors;

                if (errors) {
                    const firstKey = Object.keys(errors)[0];
                    errorMessage.value = errors[firstKey][0];
                } else {
                    errorMessage.value = error.response.data.message;
                }

                // ERRORES 4XX-5XX PERSONALIZADOS
            } else if (error.response.data?.message) {
                errorMessage.value = error.response.data.message;

            } else {
                errorMessage.value = `Error del servidor: ${error.response.status}`;
            }

        } else {
            errorMessage.value = "Error de conexión con el servidor.";
        }

        isError.value = true;
        authStore.loading = false;

    } finally {
        // 🔥 ESTO ES LO QUE TE FALTABA
        isLoading.value = false;
        console.log("loading:false");
        authStore.loading = false;

    }
};

/**
 * Elimina un producto de la lista de ítems de la venta (saleItems).
 * @param {number} inventoryId El ID del producto de inventario a eliminar.
 */
const removeItemFromSale = (inventoryId) => {

    // Filtra el array, manteniendo solo los ítems cuya ID NO coincida con la ID proporcionada.
    saleItems.value = saleItems.value.filter(item => item.inventory_id !== inventoryId);

    // Opcional: Mensaje de confirmación
    messageInventory.value = 'Producto eliminado del carrito.';
    setTimeout(() => (messageInventory.value = ''), 3000);


    console.log('TODOS LOS PRODUCTOS ::: ', saleItems.value)
};




</script>
