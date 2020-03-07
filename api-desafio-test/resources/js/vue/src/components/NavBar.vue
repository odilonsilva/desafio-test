<template>
  <div class="navbar">
    <div class="ui grid">
      <div class="ten wide column">
        <router-link to="/">Home</router-link>
      </div>
      <div class="six wide right aligned column">
        <a href @click="logout">Logout</a>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "NavBar",
  data() {
    return {};
  },
  methods: {
    logout(e) {
      e.preventDefault();
      var app = this;
      // var token = localStorage.getItem("token");
      // fetch(appBaseUrl + "/auth/logout", {
      //   method: "POST",
      //   headers: {
      //     Authorization: token
      //   }
      // })
      //   .then(response => response.json())
      //   .then(res => {
      //     if (res.status === "success") {
      localStorage.clear();
      app.$router.push({ name: "Login" });
      //   }
      // })
      // .catch(error => console.error("não foi possivel deslogar"));
    }
  }
};
</script>
<style scoped>
.navbar {
  width: 100%;
  height: 40px;
  background: #404040;
  color: silver;
  margin: 0;
  margin-bottom: 10px;
  padding: 10px;
}
.navbar a {
  display: inline;
  padding: 0px 10px;
  color: silver;
}
</style>