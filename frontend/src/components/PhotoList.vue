<template>
  <div>
    <header class="navbar navbar-dark bg-dark box-shadow">
      <div class="container d-flex justify-content-between">
        <a href="/" class="navbar-brand d-flex align-items-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
            <circle cx="12" cy="13" r="4"></circle>
          </svg>
          <strong>Album</strong>
        </a>
      </div>
    </header>

    <main role="main">
      <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">Album</h1>
        </div>
      </section>

      <div class="album py-5 bg-light">
        <div class="container">
          <div class="row">
            <div class="col-md-4" v-for="photo in photos" :key="photo.id">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" :src="getPhotoUrl(photo.image_path)" alt="Photo">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                  </div>
                </div>
                <button @click="deletePhoto(photo.id)" class="btn btn-sm btn-outline-danger" v-on:click="deletar()">Excluir</button>
              </div>
            </div>
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
        </div>
      </div>
    </main>

    <footer class="text-muted">
      <div class="container">
      </div>
    </footer>
  </div>
</template>

<script>
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap/dist/js/bootstrap.min.js';


export default {
  data() {
    return {
      photos: [], 
      selectedPhoto: null,
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
      const allowedFormats = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
      this.selectedPhoto = event.target.files[0];

      if (this.selectedPhoto) {
        if (allowedFormats.includes(this.selectedPhoto.type)) {
        } else {
          alert('O arquivo deve ser uma imagem nos formatos JPEG, PNG, JPG ou GIF.');
          this.selectedPhoto = null;

        }
      }
    },
    async deletePhoto(photoId) {
      const confirmDelete = window.confirm('Tem certeza de que deseja excluir esta foto?');
      
      if (confirmDelete) {
        try {
          await axios.delete(`http://localhost:8989/api/photos/${photoId}`);

          this.fetchPhotos();
        } catch (error) {
          console.error('Erro ao excluir a foto:', error);
        }
      }
    },
  },
  mounted() {
    this.fetchPhotos();
  },
};
</script>

<style scoped>
@import "@/assets/photo.css";
</style>
