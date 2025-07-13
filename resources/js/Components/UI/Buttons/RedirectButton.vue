<template>
  <button
    @click="$emit('save')"
    class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white shadow-md font-semibold py-2 px-2 rounded-lg"
  >
    <Eye class="w-4 h-4" />
    Exibir
  </button>
</template>

<script setup>
import { Eye } from 'lucide-vue-next';

defineEmits(['save']);
</script>
