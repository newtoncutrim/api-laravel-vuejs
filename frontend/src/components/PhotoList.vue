<template>
  <div>
    <header class="navbar navbar-dark bg-dark box-shadow">
      <div class="container d-flex justify-content-between">
        <a href="/" class="navbar-brand d-flex align-items-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
            <circle cx="12" cy="13" r="4"></circle>
          </svg>
          <strong>Album</strong>
        </a>
        <button @click="logout" class="btn btn-danger btn-block mt-2">Sair</button>
      </div>
    </header>

    <main role="main">
      <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">
            <h5> <span class="text-danger">Usuario: </span> {{ userName }}</h5>
          </h1>
        </div>
      </section>
      <div class="album py-5 bg-light">
        <div class="container">
          <div class="row">
            <table class="table">
              <thead>
                <tr>

                  <th scope="col">Foto</th>
                  <th scope="col">titulo</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="photo in photos" :key="photo.id">
                  <td>
                    <img :src="getPhotoUrl(photo.image_path)" alt="Photo" class="img-thumbnail">
                  </td>
                  <td>{{ photo.title }}</td>
                  <td>
                    <button @click="deletePhoto(photo.id)" class="btn btn-sm btn-outline-danger margin  ">Excluir</button>
                    <button @click="getPhotoId(photo.id)" type="button" class="btn btn-sm btn-outline-primary "
                      data-bs-toggle="modal" data-bs-target="#exampleModal">
                      Ver
                    </button>
                  </td>
                </tr>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ title }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                          ref="myModal"></button>
                      </div>
                      <div class="modal-body">
                        <img :src="modalPhotoUrl" alt="foto" class="img-fluid">
                      </div>
                      <div class="modal-footer">
                        <form @submit.prevent="editPhoto(this.editingPhoto.id)" method="post" enctype="multipart/form-data">
                          <div class="mb-3">
                            <label class="form-label" for="photo">Editar foto:</label>
                            <input ref="photoInput" class="form-control" type="file" id="photo" name="image_path"
                              @change="handleFileChange" accept="image/*">
                          </div>
                          <div class="mb-3">
                            <label class="form-label" for="title">Título da Imagem</label>
                            <input type="text" id="title" name="title" class="form-control" v-model="title">
                          </div>
                          <button class="btn btn-primary" type="submit">Editar</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </tbody>
            </table>
            <div v-if="totalPages > 1" class="pagination btn-group d-grid gap-2 d-md-block text-center">
              <button class="btn btn-primary" @click="changePage(currentPage - 1)"
                :disabled="currentPage === 1">Anterior</button>
              <span>Página {{ currentPage }} de {{ totalPages }}</span>
              <button class="btn btn-primary" @click="changePage(currentPage + 1)"
                :disabled="currentPage === totalPages">Próxima</button>
            </div>
            <section class="add-more mb-3">
              <p>Adicionar fotos</p>
              <form @submit.prevent="uploadPhoto" method="post" enctype="multipart/form-data">
                <div class="mb-5">
                  <label class="form-label" for="photo">Selecione uma foto:</label>
                  <input ref="photoInput" class="form-control" type="file" id="photo" name="image_path"
                    @change="handleFileChange" accept="image/*">
                  <label class="form-label" for="title">Titulo da Imagem</label>
                  <input type="text" id="title" name="title" class="form-control" v-model="title">
                </div>
                <button class="btn btn-primary" type="submit">Enviar</button>
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
import 'jquery';



export default {
  data() {
    return {
      photos: [],
      editingPhoto: {
        id: 1,
        title: '',
        image_path: '',
      },
      selectedPhoto: null,
      newSelectedPhoto: null,
      title: '',
      editedTitle: '',
      currentPage: 1,
      totalPages: 1,
      userName: "",
      modalPhotoUrl: "",
    };
  },
  methods: {
    getPhotoUrl(imagePath) {
      return `http://localhost:8989/storage/${imagePath}`;
    },
    async fetchPhotos() {
      try {
        const token = localStorage.getItem('token');
        this.userName = localStorage.getItem('userName');

        const response = await axios.get('http://localhost:8989/api/photos', {
          headers: {
            Authorization: `Bearer ${token}`,
          },

        });
        this.totalPages = response.data.total_paginas;
        this.photos = response.data.registros;
        console.log(response.data.registros)
      } catch (error) {
        console.error('Erro ao buscar fotos:', error);
      }
    },
    async uploadPhoto() {
      try {
        const token = localStorage.getItem('token');

        if (!token) {
          console.error('Token não encontrado. Redirecionando para a página de login.');
          this.$router.push('/login');
          return;
        }

        const formData = new FormData();
        formData.append('image_path', this.selectedPhoto);
        formData.append('title', this.title);

        await axios.post('http://localhost:8989/api/up', formData, {
          headers: {
            Authorization: `Bearer ${token}`,
          }
        });

        this.$refs.photoInput.value = '';
        this.title = '';
        alert('Upload realizado com sucesso')

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
      console.log(photoId)
      const confirmDelete = window.confirm('Tem certeza de que deseja excluir esta foto?');

      if (confirmDelete) {
        try {
          const token = localStorage.getItem('token');


          await axios.delete(`http://localhost:8989/api/photos/${photoId}`, {
            headers: {
              Authorization: `Bearer ${token}`,
            }
          });

          this.fetchPhotos();
        } catch (error) {
          console.error('Erro ao excluir a foto:', error);
        }
      }
    },
    async changePage(page) {
      try {
        const token = localStorage.getItem('token');

        const response = await axios.get(`http://localhost:8989/api/photos?page=${page}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          }
        });

        this.totalPages = response.data.total_paginas;
        this.photos = response.data.registros;
        this.currentPage = page;
      } catch (error) {
        console.error('Erro ao buscar fotos:', error);
      }
    },
    logout() {
      const confirmLogout = window.confirm('Tem certeza de que deseja sair?');
      if (confirmLogout) {
        localStorage.removeItem('token');
        this.$router.push('/login');
      }
    },
    async getPhotoId(photoId) {

      const token = localStorage.getItem('token');
      const response = await axios.get(`http://localhost:8989/api/photos/${photoId}`, {
        headers: {
          Authorization: `Bearer ${token}`,
        }
      });

      console.log()
      this.editingPhoto = {
        id: photoId,
        title: response.data.image_path.title,
        image_path: response.data.image_path.image_path,
      },

        this.modalPhotoUrl = this.getPhotoUrl(this.editingPhoto.image_path);
      this.title = this.editingPhoto.title
      console.log(this.title)
    },
    async editPhoto(photoId) {
      try {
        console.log(photoId)
        const token = localStorage.getItem('token');
        /* console.log(response) */
        const formData = new FormData();
        formData.append('image_path', this.selectedPhoto);
        console.log(this.title)
        formData.append('title', this.title);

        await axios.post(`http://localhost:8989/api/photo/${photoId}`, formData, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        alert("Foto atualizada com sucesso!");

        this.title = ''
        this.selectedPhoto = ''
        document.querySelector('.btn-close').click()

        this.fetchPhotos();
      } catch (error) {
        console.error('Erro ao editar a foto:', error);
      }
    },
  },
  mounted() {
    this.fetchPhotos();
  },
};
</script>

<style scoped>.img-thumbnail {
  width: 150px;
  height: 150px;
  object-fit: cover;
}

.margin {
  margin-right: 10px;
}</style>
