<template>
    <div class="container mt-5">
      <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-header text-center">
          <img src="http://danielzawadzki.com/codepen/01/icon.svg" alt="User Icon" style="width: 60%;" />
        </div>
        <div class="card-body">

          <form @submit.prevent="submitForm">
            <div class="form-group">
              <input type="email" v-model="email" class="form-control" name="email" placeholder="email">
            </div>
            <div class="form-group">
              <input type="password" v-model="password" class="form-control" name="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
          </form>
        </div>
        <div class="card-footer text-center">
          <a class="underlineHover" href="#">Esqueceu a senha?</a>
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
      };
    },
    methods: {
      submitForm() {
        const formData = {
          email: this.email,
          password: this.password,
        };
        console.log(formData)
        // Chamada para a API de login
        axios.post('http://localhost:8989/api/auth/login', formData)
          .then(response => {
            console.log(response.data.data.token)
            const token = response.data.data.token;
  
            localStorage.setItem('token', token);
  
            // Redirecionar para a página após o login
            /* this.$router.push('/home'); */
          })
          .catch(error => {
            // Trate erros de autenticação aqui
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
  