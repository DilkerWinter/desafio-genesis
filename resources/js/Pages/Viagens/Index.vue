<template>
    <div>
        <h1>teste</h1>
    </div>
</template>

<script setup>
const props = defineProps({
  viagens: {
    type: Object,
    required: true,
  },
});

console.log(props.viagens);
</script>
