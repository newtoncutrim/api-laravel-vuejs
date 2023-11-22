<template>
    <div>
      <h1>Lista de Fotos</h1>
      <ul>
        <li v-for="photo in photos" :key="photo.id">
          <img :src="getPhotoUrl(photo.image_path)" alt="Photo">
          <button @click="deletePhoto(photo.id)">Excluir</button>
        </li>
      </ul>
      <section class="add-more">
    <p>Adicionar fotos</p>
    <form @submit.prevent="uploadPhoto" method="post" enctype="multipart/form-data">
      <label for="photo">Selecione uma foto:</label>
      <input type="file" id="photo" name="image_path" @change="handleFileChange" accept="image/*">
      <br><br>
      <button type="submit">Enviar</button>
    </form>
  </section>
  
  
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        photos: [],   
        selectedPhoto: null 
      };
    },
    methods: {
      getPhotoUrl(imagePath) {
        return `http://localhost:8989/storage/${imagePath}`;
      },
      async fetchPhotos() {
        try {
          const response = await axios.get('http://localhost:8989/api/photos');
          this.photos = response.data.data;
        } catch (error) {
          console.error('Erro ao buscar fotos:', error);
        }
      },
      async uploadPhoto() {
        try {
          const formData = new FormData();
          formData.append('image_path', this.selectedPhoto);
  
          await axios.post('http://localhost:8989/api/up', formData);
  
          this.fetchPhotos();
        } catch (error) {
          console.error('Erro ao fazer upload da foto:', error);
        }
      },
      handleFileChange(event) {

        this.selectedPhoto = event.target.files[0];
      },
      async deletePhoto(photoId) {
        try {
          await axios.delete(`http://localhost:8989/api/photos/${photoId}`);
  
          this.fetchPhotos();
        } catch (error) {
          console.error('Erro ao excluir a foto:', error);
        }
      },
    },
    mounted() {
      this.fetchPhotos();
    },
  };
  </script>
  
  <style scoped>

  </style>
  