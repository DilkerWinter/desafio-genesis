<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Lista de Viagens</h1>
    <table class="table-auto w-full border-collapse border border-gray-300">
      <thead>
        <tr>
          <th class="border border-gray-300 px-4 py-2">Motorista</th>
          <th class="border border-gray-300 px-4 py-2">Veiculol</th>
          <th class="border border-gray-300 px-4 py-2">Inicio</th>
          <th class="border border-gray-300 px-4 py-2">Fim</th>
          <th class="border border-gray-300 px-4 py-2">Kilometragem Inicial</th>
          <th class="border border-gray-300 px-4 py-2">Kilometragem Final</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="viagem in viagens" :key="viagem.id" class="hover:bg-gray-100">
          <td class="border border-gray-300 px-4 py-2">{{ viagem.motorista.nome }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ viagem.veiculo.modelo }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ viagem.data_hora_inicial }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ viagem.data_hora_final }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ viagem.km_inicial }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ viagem.km_final }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
const { viagens } = defineProps({
  viagens: Array
});

console.log(viagens);
</script>
