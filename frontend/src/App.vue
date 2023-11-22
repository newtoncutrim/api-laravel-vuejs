<script setup>
import { RouterLink, RouterView } from 'vue-router'
import PhotoList from '@/components/PhotoList.vue';
</script>

<template>
  <header>

<!--     <nav>
      <RouterLink to="/">Home</RouterLink> 
      <RouterLink to="/about">about</RouterLink> 
    </nav> -->
  </header>
  <PhotoList />
</template>


<style scoped>
@import "@/assets/photo.css";
</style>
