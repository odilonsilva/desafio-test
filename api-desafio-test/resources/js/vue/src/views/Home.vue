<template>
  <div class="home">
    <h1>{{ appName }}</h1>

    <router-link to="/create" class="ui blue button" title="Cadastrar novo usuário">Novo</router-link>

    <table class="ui table" v-if="userList.length > 0">
      <thead>
        <th>id</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Ações</th>
      </thead>
      <tbody>
        <ItemTable v-for="user in userList" v-bind:element="user" v-bind:key="user.id"></ItemTable>
      </tbody>
    </table>
    <div class="ui center aligned segment" v-if="isLoading">
      <img src="/loading.gif" width="50" />
      <p>Carregando...</p>
    </div>
    <div class="ui center aligned segment" v-if="isLoading == false && userList.length == 0">
      <h4>Nenhum usuário cadastrado</h4>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import ItemTable from "../components/ItemTable.vue";
import Navbar from "../components/NavBar.vue";
export default {
  name: "Home",
  components: {
    ItemTable,
    Navbar
  },
  data() {
    return {
      isLoading: false,
      appName: "Home",
      appTitle: null,
      userList: []
    };
  },
  methods: {
    loadList: function() {
      var app = this;
      app.isLoading = true;
      fetch(appBaseUrl + "/auth/list")
        .then(response => response.json())
        .then(res => {
          app.appTitle = "Lista de Usuários";
          app.isLoading = false;
          if (res.status === "success") this.userList = res.data;
        })
        .catch(err => {
          app.appTitle = "Lista de Usuários";
          app.isLoading = false;
          console.error("falha ao buscar dado para a lista: " + err);
        });
    },
    removeUser(id){
      this.userList = this.userList.filter(element => element.id != id ? element : null)
    },
    inverterLista: () => {
      this.userList.reverse();
    }
  },
  beforeMount() {
    this.$parent.hasUser = true
    this.loadList();
    console.log("mounted");
  }
};
</script>
