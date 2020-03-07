<template>
  <div class="ui aligned center aligned grid" style="margin-top:100px">
    <div class="ten wide column">
      <h2 class="ui header">
        <div class="content">Login</div>
      </h2>
      <form class="ui form">
        <div class="ui stacked segment">
          <div class="field">
            <div class="ui left icon input">
              <i class="user icon"></i>
              <input type="text" v-model="email" name="email" placeholder="E-mail address" />
            </div>
          </div>
          <div class="field">
            <div class="ui left icon input">
              <i class="lock icon"></i>
              <input type="password" v-model="password" name="password" placeholder="Password" />
            </div>
          </div>
          <div class="ui fluid large blue submit button" @click="login">Login</div>
        </div>

        <div class="ui negative message" v-if="hasError">Falha ao logar</div>
        <div class="ui center aligned segment" v-if="isLoading">
          <img src="/loading.gif" width="50" />
          <p>Carregando...</p>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  name: "login",
  data() {
    return {
      isLoading: false,
      email: null,
      password: null,
      hasError: false
    };
  },
  methods: {
    login: function() {
      var app = this;
      app.hasError = false;
      app.isLoading = true;
      fetch(appBaseUrl + "/auth/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          email: app.email,
          password: app.password
        })
      })
        .then(response => response.json())
        .then(res => {
          app.isLoading = false;
          if (res.status === "success") {
            window.localStorage.setItem("token", res.token);
            app.$router.push({ name: "home" });
          } else {
            app.hasError = true;
          }
        })
        .catch(error => {
          app.isLoading = false;
          console.error("não foi possivel realizar o login:" + error);
        });
    }
  },
  beforeMount() {
    this.$parent.hasUser = false;
  }
};
</script>
