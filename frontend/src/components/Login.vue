<template>
    <div class="container mt-5">
      <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-header text-center">
          <h2><strong>Login</strong></h2>
        </div>
        <div class="card-body">

        <form @submit.prevent="submitForm">
          <div class="form-group pb-3">
            <input type="email" v-model="email" class="form-control" name="email" placeholder="Email">
          </div>
          <div class="form-group pb-3">
            <div class="input-group">
              <input
                v-model="password"
                class="form-control"
                name="password"
                placeholder="Password"
                :type="showPassword ? 'text' : 'password'"
              >
              <div class="input-group-append">
                <button class="btn btn-outline-secondary marge" type="button" @click="togglePasswordVisibility">
                  <i v-if="icon == true" class="bi bi-eye-fill" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                  <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                  <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                </svg></i>
                <i v-if="icon == false" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486z"/>
                <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
                <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708"/>
                </svg></i>
                </button>
              </div>
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary btn-block mx-auto">Entrar</button>
          </div>
          <div v-if="loginErrors.length > 0" class="alert alert-danger mt-3">
            <ul>
              <li v-for="error in loginErrors" :key="error">{{ error }}</li>
            </ul>
          </div>
        </form>

        </div>
        <div class="card-footer">
          <p>Deseja se cadastrar?</p>
          <RouterLink to="/cadastro" >Cadastro</RouterLink>   
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        email: '',
        password: '',
        showPassword: false,
        loginErrors: [],
        icon: false
      };
    },
    methods: {
      submitForm() {
        const formData = {
          email: this.email,
          password: this.password,
        };
        // Chamada para a API de login
        axios.post('http://localhost:8989/api/auth/login', formData)
          .then(response => {
            const token = response.data.data.token;
            const nome = response.data.data.user.name;
            /* console.log(nome) */
            if(token){
              localStorage.setItem('token', token);
              localStorage.setItem('userName', nome);
  
              this.$router.push('/');
            }

          })
          .catch(error => {
            if (error.response && error.response.data && error.response.data.errors) {
            this.loginErrors = Object.values(error.response.data.errors).flat();
            }
            if(error.response.status === 500){
              alert('Usuario não cadastrado')
            }
            console.error('Erro ao realizar login:', error);
          });
        },
        togglePasswordVisibility() {
          this.showPassword = !this.showPassword;
          this.icon = !this.icon
        },
    },
  };
  </script>
  
  <style scoped>
  .underlineHover:after {
    display: block;
    left: 0;
    bottom: -10px;
    width: 0;
    height: 2px;
    background-color: #007bff;
    content: "";
    transition: width 0.2s;
  }
  
  .underlineHover:hover {
    color: #0056b3;
  }
  .marge{
    margin-left: 8px;
  }
  .underlineHover:hover:after {
    width: 100%;
  }
  </style>
  