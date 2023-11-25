<template>
  <div class="container mt-5">
    <div class="card mx-auto" style="max-width: 400px;">
      <div class="card-header text-center">
        <h2>Cadastro</h2>
      </div>
      <div class="card-body">
        <form @submit.prevent="submitForm">
          <div class="form-group pb-3">
            <input type="text" v-model="login" class="form-control" name="name" placeholder="Login">
          </div>
          <div class="form-group pb-3">
            <input type="email" v-model="email" class="form-control" name="email" placeholder="Email">
          </div>
          <div class="form-group pb-3">
            <input type="password" v-model="password" class="form-control" name="password" placeholder="Password" @input="checkPassword">
            <small v-if="showPasswordError" class="text-danger">A senha deve ter pelo menos 8 caracteres, uma letra maiúscula e um símbolo.</small>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary btn-block mx-auto" :disabled="showPasswordError">Cadastrar</button>
          </div>
          <div v-if="registrationErrors.length > 0" class="alert alert-danger mt-3">
            <ul>
              <li v-for="error in registrationErrors" :key="error">{{ error }}</li>
            </ul>
          </div>
        </form>
      </div>
      <div class="card-footer">
        <p>Deseja fazer Login?</p>
          <RouterLink to="/login" >Login</RouterLink>  
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      login: '',
      password: '',
      email: '',
      showPasswordError: false,
      registrationErrors: [],
    };
  },
  methods: {
    submitForm() {
      const formData = {
        name: this.login,
        password: this.password,
        email: this.email,
      };

      // Chamada para a API de cadastro
      axios.post('http://localhost:8989/api/users', formData)
        .then(response => {
          console.log('Cadastro realizado com sucesso:', response.data);
          this.$router.push('/login');
        })
        .catch(error => {
          console.error('Erro ao cadastrar:', error);
          if (error.response && error.response.data && error.response.data.errors) {
          this.registrationErrors = Object.values(error.response.data.errors).flat();
          }
        });
    },
    checkPassword() {
      const regex = /^(?=.*[A-Z])(?=.*[!@#$%^&*])(.{8,})$/;
      this.showPasswordError = !regex.test(this.password);
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

.underlineHover:hover:after{
  width: 100%;
}
</style>
