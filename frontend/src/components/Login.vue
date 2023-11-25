<template>
    <div class="container mt-5">
      <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-header text-center">
          <h2><strong>Login</strong></h2>
        </div>
        <div class="card-body">

          <form @submit.prevent="submitForm">
            <div class="form-group pb-3">
              <input type="email" v-model="email" class="form-control" name="email" placeholder="email">
            </div>
            <div class="form-group pb-3">
              <input type="password" v-model="password" class="form-control" name="password" placeholder="Password">
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
        loginErrors: [],
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
            console.error('Erro ao realizar login:', error);
          });
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
  
  .underlineHover:hover:after {
    width: 100%;
  }
  </style>
  