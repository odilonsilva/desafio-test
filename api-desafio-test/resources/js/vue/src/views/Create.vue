<template>
  <div class="ui segment">
    <h1>{{ appTitle }}</h1>
    <form class="ui form">
      <div class="field">
        <label>Nome</label>
        <input type="text" v-model="user.name" name="name" placeholder="Nome" />
      </div>
      <div class="field">
        <label>Email</label>
        <input type="text" v-model="user.email" name="email" placeholder="Email" />
      </div>
      <div class="field">
        <label>Senha</label>
        <input type="password" v-model="user.password" name="senha" placeholder="Senha" />
      </div>
      <div class="field">
        <label>Confirmar Senha</label>
        <input
          type="password"
          v-model="user.repassword"
          name="resenha"
          placeholder="Confirmar senha"
        />
      </div>

      <div class="ui positive message" v-if="hasSuccess">
        <i class="close icon"></i>
        <div class="header">Sucesso!</div>
        <p>Usuário cadastrado com sucesso.</p>
      </div>

      <div class="ui negative message" v-if="hasError">
        <i class="close icon"></i>
        <div class="header">{{errorMessageTitle}}</div>
        <p>{{errorMessage}}</p>
      </div>

      <button class="ui button" type="submit" @click="save">Salvar</button>
    </form>
    <div class="ui center aligned segment" v-if="isLoading">
      <img src="/loading.gif" width="50" />
      <p>Salvando...</p>
    </div>
  </div>
</template>
<script>
export default {
  name: "CreateForm",
  data() {
    return {
      appTitle: "Novo Usuário",
      isLoading: false,
      user: {
        nome: null,
        email: null,
        password: null,
        repassword: null
      },
      hasError: false,
      errorMessage: "",
      errorMessageTitle: null,
      hasSuccess: false
    };
  },
  methods: {
    save(e) {
      e.preventDefault();
      var app = this;
      if (this.user.password != this.user.repassword) {
        this.hasError = true;
        this.errorMessage = "A senha é diferente do campo confirmar senha";
        this.errorMessageTitle = "Erro no preenchimento";
        return false;
      }
      app.isLoading = true
      fetch(appBaseUrl + "/auth/register", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          name: this.user.name,
          email: this.user.email,
          password: this.user.password
        })
      })
        .then(response => response.json())
        .then(res => {
          app.isLoading = false
          if (res.status == "error") {
            app.hasError = true;
            app.errorMessageTitle = "Ocorreu um erro";

            for (const key in res.errors) {
              if (res.errors.hasOwnProperty(key)) {
                const element = res.errors[key];
                app.errorMessage += element;
                console.log(element);
              }
            }
            return false;
          }
          app.hasError = false;
          app.hasSuccess = true;
        })
        .catch(error => {
          app.isLoading = false
          app.errorMessageTitle = "Ocorreu um erro";
          app.errorMessage = error;
        });
    }
  }
};
</script>