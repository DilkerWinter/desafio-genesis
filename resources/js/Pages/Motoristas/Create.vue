<template>
  <div class="max-w-md mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-xl font-bold mb-4">Cadastro</h1>

    <form @submit.prevent="submit">
      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Nome</label>
        <TextInput
          v-model="form.nome"
          type="text"
          class="w-full border border-gray-300 rounded px-3 py-2"
        />
        <div v-if="form.errors.nome" class="text-red-600 text-sm">{{ form.errors.nome }}</div>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">CNH</label>
        <TextInput
          v-model="form.cnh"
          type="text"
          class="w-full border border-gray-300 rounded px-3 py-2"
        />
        <div v-if="form.errors.cnh" class="text-red-600 text-sm">{{ form.errors.cnh }}</div>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Data de Nascimento</label>
        <TextInput
          v-model="form.data_nascimento"
          type="date"
          class="w-full border border-gray-300 rounded px-3 py-2"
        />
        <div v-if="form.errors.data_nascimento" class="text-red-600 text-sm">{{ form.errors.data_nascimento }}</div>
      </div>

      <button
        type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
      >
        Cadastrar
      </button>
    </form>
  </div>
</template>

<script setup>
import TextInput from '@/Components/TextInput.vue'
import { useForm } from '@inertiajs/vue3'
import TextInput from 'vendor/laravel/breeze/stubs/inertia-react/resources/js/Components/TextInput'

const form = useForm({
  nome: '',
  cnh: '',
  data_nascimento: '',
})

const submit = () => {
  form.post('/cadastro')
}
</script>
