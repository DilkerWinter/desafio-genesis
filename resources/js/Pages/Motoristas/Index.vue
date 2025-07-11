<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Lista de Motoristas</h1>
    <table class="table-auto w-full border-collapse border border-gray-300">
      <thead>
        <tr>
          <th class="border border-gray-300 px-4 py-2">Nome</th>
          <th class="border border-gray-300 px-4 py-2">Data Nascimento</th>
          <th class="border border-gray-300 px-4 py-2">Numero CNH</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="motorista in motoristas" :key="motorista.id" class="hover:bg-gray-100">
          <td class="border border-gray-300 px-4 py-2">{{ motorista.nome }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ motorista.data_nascimento }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ motorista.cnh }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
defineProps({
  motoristas: Array
});
</script>
