<template>
  <div class="p-6 bg-gray-100 min-h-screen">
    <div class="max-w-6xl mx-auto">

      <div
        class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 text-center sm:text-left p-4 bg-white rounded-lg shadow"
      >
        <h1 class="text-3xl font-semibold mb-4 sm:mb-0">Painel dos Motoristas</h1>
        <button
          class="bg-blue-600 text-white px-6 py-2.5 rounded-lg shadow hover:bg-blue-700 transition"
        >
          Cadastrar novo motorista
        </button>
      </div>

      <div>
        <MotoristaDataTable :motoristas="motoristas" />
      </div>

    </div>
  </div>
</template>

<script setup>
import MotoristaDataTable from '@/Components/UI/DataTable/MotoristaDataTable.vue';

defineProps({
  motoristas: {
    type: Object,
    required: true,
  },
});
</script>
