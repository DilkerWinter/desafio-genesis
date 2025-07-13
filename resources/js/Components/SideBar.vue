<template>
  <aside
    :class="[
      'bg-white shadow-md h-screen p-4 flex flex-col transition-width duration-300',
      isOpen ? 'w-64' : 'w-16'
    ]"
  >
    <div class="flex items-center justify-between mb-6">
      <h2 v-if="isOpen" class="text-xl font-bold">Sistema de Viagens</h2>
      <button
        @click="toggleSidebar"
        class="text-gray-600 hover:text-gray-900 focus:outline-none"
        aria-label="Toggle sidebar"
      >
        <component :is="isOpen ? XIcon : MenuIcon" class="w-6 h-6" />
      </button>
    </div>

    <p v-if="isOpen" class="text-sm text-gray-600 mb-6">Entrevista Tecnica Genesis</p>

    <nav class="flex flex-col space-y-4">
      <Link
        href="/viagens"
        class="flex items-center space-x-2 text-gray-700 hover:text-blue-600"
      >
        <Navigation class="w-6 h-6" />
        <span v-if="isOpen">Viagens</span>
      </Link>
      <Link
        href="/veiculos"
        class="flex items-center space-x-2 text-gray-700 hover:text-blue-600"
      >
        <Car class="w-6 h-6" />
        <span v-if="isOpen">Veículos</span>
      </Link>
      <Link
        href="/motoristas"
        class="flex items-center space-x-2 text-gray-700 hover:text-blue-600"
      >
        <User class="w-6 h-6" />
        <span v-if="isOpen">Motoristas</span>
      </Link>
    </nav>
  </aside>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

import { MenuIcon, XIcon, Navigation, Car, User } from 'lucide-vue-next';

const isOpen = ref(true);

function toggleSidebar() {
  isOpen.value = !isOpen.value;
}
</script>

<style>
aside {
  transition-property: width;
  transition-timing-function: ease;
  transition-duration: 300ms;
}
</style>
