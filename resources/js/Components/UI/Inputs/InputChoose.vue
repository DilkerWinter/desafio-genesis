<template>
  <select
    :value="modelValue"
    @change="$emit('update:modelValue', $event.target.value)"
    @blur="$emit('blur')"
    class="w-full border rounded px-2 py-1"
  >
    <option value="" disabled>{{ placeholder }}</option>
    <option
      v-for="item in options"
      :key="item[idKey]"
      :value="item[idKey]"
    >
      {{ item[labelKey] }}
    </option>
  </select>
</template>

<script setup>
defineProps({
  modelValue: [String, Number],
  options: {
    type: Array,
    default: () => []
  },
  placeholder: {
    type: String,
    default: 'Selecione...'
  },
  idKey: {
    type: String,
    default: 'id'
  },
  labelKey: {
    type: String,
    default: 'label'
  }
});
defineEmits(['update:modelValue', 'blur']);
</script>
