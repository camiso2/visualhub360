<template>

    <div>
        <button @click="goBack" type="button" title="Volver a la página anterior" class="mt-1
      inline-flex items-center px-3 py-0 border border-gray-300 shadow-sm
      text-sm font-medium rounded-md text-gray-700 bg-white
      hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
      transition duration-150 ease-in-out
    ">
            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>

            Volver
        </button>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
const usRouter = useRouter();
const goBack = () => {
    usRouter.back();
};
</script>
