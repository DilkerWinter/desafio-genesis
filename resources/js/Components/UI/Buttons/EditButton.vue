<template>
  <button
    @click="$emit('editar')"
    class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white shadow-md font-semibold py-2 px-2 rounded-lg"
  >
    <Edit class="w-4 h-4" />
    Editar
  </button>
</template>

<script setup>
import { Edit } from 'lucide-vue-next';

defineEmits(['editar']);
</script>
