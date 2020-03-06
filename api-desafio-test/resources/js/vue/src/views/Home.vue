<template>
  <div class="home">
    <h1>{{ appName }}</h1>

    <table>
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
export default {
  name: "Home",
  components: {
    ItemTable
  },
  data() {
    return {
      appName: "User List",
      userList: [
        { id: 1, name: "Odilon", email: "odilon.silva1@outlook.com.br" },
        { id: 2, name: "Antonio", email: "aalgusto@gmail.com" }
      ],
      seen: false,
      message: "Hello Vue"
    };
  },
  methods: {
    inverterLista: () => {
      this.userList.reverse();
    }
  }
};
</script>
