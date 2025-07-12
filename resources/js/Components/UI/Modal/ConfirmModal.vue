<template>
  <div
    v-if="show"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    @click.self="$emit('cancelar')"
  >
    <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
      <h2 class="text-lg font-semibold mb-4">{{ titulo }}</h2>
      <p class="mb-6">{{ mensagem }}</p>
      <div class="flex justify-end gap-4">
        <button
          @click="$emit('cancelar')"
          class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400"
        >
          Cancelar
        </button>
        <button
          @click="$emit('confirmar')"
          :class="[
            'px-4 py-2 text-white rounded-md',
            tipoClasse,
            tipoHoverClasse
          ]"
        >
          Confirmar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  show: Boolean,
  titulo: {
    type: String,
    default: 'Confirmar ação',
  },
  mensagem: {
    type: String,
    default: 'Você tem certeza que deseja continuar?',
  },
  tipo: {
    type: String,
    default: 'neutra',
    validator: (val) => ['neutra', 'salvar', 'deletar'].includes(val),
  },
});

const tipoClasse = computed(() => {
  switch (props.tipo) {
    case 'salvar':
      return 'bg-green-600';
    case 'deletar':
      return 'bg-red-600';
    default:
      return 'bg-blue-600';
  }
});

const tipoHoverClasse = computed(() => {
  switch (props.tipo) {
    case 'salvar':
      return 'hover:bg-green-700';
    case 'deletar':
      return 'hover:bg-red-700';
    default:
      return 'hover:bg-blue-700';
  }
});
</script>
