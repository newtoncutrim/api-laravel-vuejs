<template>
  <div class="container mt-5">
    <div class="card mx-auto" style="max-width: 400px;">
      <div class="card-header text-center">
        <img src="http://danielzawadzki.com/codepen/01/icon.svg" alt="User Icon" style="width: 60%;" />
      </div>
      <div class="card-body">
        <!-- Formulário de Cadastro -->
        <form @submit.prevent="submitForm">
          <div class="form-group">
            <input type="text" v-model="login" class="form-control" name="name" placeholder="Login">
          </div>
          <div class="form-group">
            <input type="email" v-model="email" class="form-control" name="email" placeholder="Email">
          </div>
          <div class="form-group">
            <input type="password" v-model="password" class="form-control" name="password" placeholder="Password" @input="checkPassword">
            <small v-if="showPasswordError" class="text-danger">A senha deve ter pelo menos 8 caracteres, uma letra maiúscula e um símbolo.</small>
          </div>
          <button type="submit" class="btn btn-primary btn-block" :disabled="showPasswordError">Cadastrar</button>
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
      login: '',
      password: '',
      email: '',
      showPasswordError: false,
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
          // Trate a resposta da API conforme necessário
          console.log('Cadastro realizado com sucesso:', response.data);
          this.$router.push('/login');
        })
        .catch(error => {
          // Trate erros de requisição aqui
          console.error('Erro ao cadastrar:', error);
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
