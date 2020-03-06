<template>
  <div class="home">
    <h1>{{ appName }}</h1>

    <table class="ui table">
      <thead>
        <th>id</th>
        <th>Nome</th>
        <th>Email</th>
      </thead>
      <tbody>
        <ItemTable v-for="user in userList" v-bind:element="user" v-bind:key="user.id"></ItemTable>
      </tbody>
    </table>
  </div>
</template>

<script>
// @ is an alias to /src
import ItemTable from "../components/ItemTable.vue";
import Navbar from '../components/NavBar.vue'
export default {
  name: "Home",
  components: {
    ItemTable,
    Navbar
  },
  data() {
    return {
      appName: "User List",
      userList: [
        { id: 1, name: "Odilon", email: "odilon.silva1@outlook.com.br" },
        { id: 2, name: "Antonio", email: "aalgusto@gmail.com" }
      ],
      message: "Hello Vue",
    };
  },
  methods: {
    inverterLista: () => {
      this.userList.reverse();
    }
  }
};
</script>
