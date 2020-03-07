<template>
  <div>
    <div class="ui segment" v-if="isLoading == false">
      <h1>
        <router-link to="/" class="small ui icon button" title="Voltar para home"><</router-link>
        {{ appTitle }}
      </h1>
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
          <p>Usuário atualizado com sucesso.</p>
        </div>

        <div class="ui negative message" v-if="hasError">
          <i class="close icon"></i>
          <div class="header">{{errorMessageTitle}}</div>
          <p>{{errorMessage}}</p>
        </div>

        <button class="ui blue button" type="submit" @click="save">Salvar</button>
      </form>
    </div>
    <div class="ui center aligned segment" v-if="isLoading">
      <img src="/loading.gif" width="50" />
      <p>Carregando...</p>
    </div>
    <div class="ui center aligned segment" v-if="isSaving">
      <img src="/loading.gif" width="50" />
      <p>Salvando...</p>
    </div>
  </div>
</template>
<script>
export default {
  name: "Update",
  data() {
    return {
      appTitle: "Novo Usuário",
      isLoading: false,
      isSaving: false,
      id: null,
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
    save: function(e) {
      e.preventDefault();
      var app = this;
      if (this.user.password != this.user.repassword) {
        this.hasError = true;
        this.errorMessage = "A senha é diferente do campo confirmar senha";
        this.errorMessageTitle = "Erro no preenchimento";
        return false;
      }
      app.isSaving = true;
      fetch(appBaseUrl + "/auth/update", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          id: this.id,
          name: this.user.name,
          email: this.user.email,
          password: this.user.password
        })
      })
        .then(response => response.json())
        .then(res => {
          app.isSaving = false;
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
          app.isSaving = false;
          app.errorMessageTitle = "Ocorreu um erro";
          app.errorMessage = error;
        });
    },
    loadUser() {
      var app = this;
      app.isLoading = true;
      fetch(appBaseUrl + "/auth/user/" + app.id)
        .then(response => response.json())
        .then(res => {
          app.isLoading = false;
          if (res.status === "success") {
            app.appTitle = `Editar ${res.data.name}`;
            this.user = res.data;
          }
        })
        .catch(err => {
          app.appTitle = `Editar`;
          app.isLoading = false;
          console.error("falha ao buscar dado para a lista: " + err);
        });
    }
  },
  beforeMount() {
    var id = this.$route.params != undefined ? this.$route.params.id : null;
    if (id) {
      this.id = id;
      this.loadUser();
    }
  }
};
</script>