<template>
  <form class="ui form">
    <div class="field">
      <label>Nome</label>
      <input type="text" v-model="nome" name="name" placeholder="Nome" />
    </div>
    <div class="field">
      <label>Email</label>
      <input type="text" v-model="email" name="email" placeholder="Email" />
    </div>
    <div class="field">
      <label>Senha</label>
      <input type="password" v-model="password" name="senha" placeholder="Senha" />
    </div>
    <div class="field">
      <label>Confirmar Senha</label>
      <input type="password" v-model="repassword" name="resenha" placeholder="Confirmar senha" />
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
</template>
<script>
export default {
  name: "CreateForm",
  data() {
    return {
      nome: null,
      email: null,
      password: null,
      repassword: null,
      hasError: false,
      errorMessage: "",
      errorMessageTitle: null,
      hasSuccess: false
    };
  },
  methods: {
    save: function(e) {
      e.preventDefault();
      var app = this;
      if (this.password != this.repassword) {
        this.hasError = true;
        this.errorMessage = "A senha é diferente do campo confirmar senha";
        this.errorMessageTitle = "Erro no preenchimento";
        return false;
      }
      fetch(appBaseUrl + "/auth/register", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          name: this.nome,
          email: this.email,
          password: this.password
        })
      })
        .then(response => response.json())
        .then(res => {
          if (res.status == "error") {
            app.hasError = true
            app.errorMessageTitle = "Ocorreu um erro"

            for (const key in res.errors) {
              if (res.errors.hasOwnProperty(key)) {
                const element = res.errors[key]
                app.errorMessage += element
                console.log(element)
              }
            }
            return false
          }
          app.hasError = false
          app.hasSuccess = true
        })
        .catch(error => {
          app.errorMessageTitle = "Ocorreu um erro"
          app.errorMessage = error
        });
    }
  }
};
</script>