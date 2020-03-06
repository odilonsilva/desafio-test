<template>
  <div class="navbar">
    <router-link to="create">Novo</router-link>
    <router-link to="/">Lista</router-link>
    <a href @click="logout">Logout</a>
  </div>
</template>
<script>
export default {
  name: "NavBar",
  data() {
    return {};
  },
  methods: {
    logout: function(e) {
      e.preventDefault();
      var app = this;
      var token = localStorage.getItem("token");
      fetch(appBaseUrl + "/auth/logout", {
        method: "POST",
        headers: {
          Authorization: token
        }
      })
        .then(response => response.json())
        .then(res => {
          if (res.status === "success") {
            localStorage.clear();
            app.$router.push({ name: "login" });
          }
        })
        .catch(error => console.error("não foi possivel deslogar"));
    }
  }
};
</script>
<style scoped>
    .navbar{
        width: 100%;
        height: 40px;
        background: #404040;
        color: silver;
        margin-bottom: 10px;
        padding: 10px;
    }
    .navbar a{
        display: inline;
        padding: 0px 10px;
        color: silver;
    }
</style>