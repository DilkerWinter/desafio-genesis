<template>
  <button
    @click="$emit('save')"
    class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white shadow-md font-semibold py-2 px-2 rounded-lg"
  >
    <Save class="w-4 h-4" />
    Salvar
  </button>
</template>

<script setup>
import { Save } from 'lucide-vue-next';

defineEmits(['save']);
</script>
