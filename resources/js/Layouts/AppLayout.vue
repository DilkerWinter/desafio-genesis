<template>
  <div class="flex min-h-screen bg-gray-100">
    <SideBar />
    <main class="flex-1 p-6">
      <slot />
    </main>
  </div>
</template>

<script setup>
import SideBar from '@/Components/SideBar.vue';

</script>
