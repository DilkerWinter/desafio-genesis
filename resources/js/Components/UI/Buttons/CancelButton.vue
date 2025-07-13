<template>
  <button
    @click="$emit('cancel')"
    class="flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white shadow-md font-semibold py-2 px-4 rounded-lg"
  >
    Cancelar
  </button>
</template>

<script setup>
import { XCircle } from 'lucide-vue-next';

defineEmits(['cancel']);
</script>
