<template>
  <button
    @click="$emit('delete')"
    class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white shadow-md font-semibold py-2 px-4 rounded-lg"
  >
    <Trash class="w-4 h-4" />
  </button>
</template>

<script setup>
import { Trash } from 'lucide-vue-next';

defineEmits(['delete']);
</script>
