<template>
  <div class="bg-white p-6 rounded-xl shadow flex items-center gap-4">
    <i :class="['text-3xl text-blue-500', 'fas', icon]"></i>
    <div>
      <p class="text-gray-500 text-sm">{{ title }}</p>
      <p class="text-xl font-semibold">{{ value }}</p>
    </div>
  </div>
</template>

<script setup>
defineProps({ title: String, value: String, icon: String })
</script>
