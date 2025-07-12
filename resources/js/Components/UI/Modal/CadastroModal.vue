<template>
  <div
    v-if="show"
    @click="close"
    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50"
  >
    <div 
    @click.stop
    class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">

      <div class="space-y-4">
        <slot></slot>
      </div>

      <div class="mt-6 flex justify-end gap-3">
        <button
          @click="close"
          class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400"
        >
          Cancelar
        </button>
        <button
          @click="$emit('save')"
          class="px-4 py-2 text-white rounded-md bg-green-600 hover:bg-green-700"
        >
          Salvar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
  show: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["close", "save"]);

function close() {
  emit("close");
}
</script>
