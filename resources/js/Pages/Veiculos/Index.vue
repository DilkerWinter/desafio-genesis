<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Lista de Veículos</h1>
    <table class="table-auto w-full border-collapse border border-gray-300">
      <thead>
        <tr>
          <th class="border border-gray-300 px-4 py-2">Modelo</th>
          <th class="border border-gray-300 px-4 py-2">Ano</th>
          <th class="border border-gray-300 px-4 py-2">Placa</th>
          <th class="border border-gray-300 px-4 py-2">Renavam</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="veiculo in veiculos" :key="veiculo.id" class="hover:bg-gray-100">
          <td class="border border-gray-300 px-4 py-2">{{ veiculo.modelo }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ veiculo.ano }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ veiculo.placa }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ veiculo.renavam }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
defineProps({
  veiculos: Array
});
</script>
