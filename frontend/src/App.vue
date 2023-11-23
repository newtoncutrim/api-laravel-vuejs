<script setup>
import { RouterLink, RouterView } from 'vue-router'
import PhotoList from '@/components/PhotoList.vue';
import CadastroView from './views/CadastroView.vue';
</script>

<template>
  <div>
    <header>
    <nav>
      <RouterLink to="/" class="nav-link">Home</RouterLink> 
      <RouterLink to="/cadastro" class="nav-link">cadastro</RouterLink>       
      <RouterLink to="/login" class="nav-link"> Login</RouterLink>
    </nav>
    </header>
    <RouterView/>
  </div>
</template>


<style scoped>
@import "@/assets/photo.css";
</style>
