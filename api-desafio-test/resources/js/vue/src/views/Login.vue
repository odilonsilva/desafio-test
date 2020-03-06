<template>
  <div class="ui middle aligned center aligned grid">
    <div class="column">
      <h2 class="ui teal image header">
        <div class="content">Login</div>
      </h2>
      <form class="ui large form">
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
          <div class="ui fluid large teal submit button" @click="login">Login</div>
        </div>

        <div class="ui error message" v-if="hasError">Falha ao logar</div>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  name: "login",
  data() {
    return {
      email: null,
      password: null,
      hasError: false
    };
  },
  methods: {
    login: function() {
      var app = this;
      app.hasError = false;
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
          if (res.status === "success") {
            window.localStorage.setItem("token", res.token);
            app.$router.push({name:"home"});
          } else {
            app.hasError = true;
          }
        })
        .catch(error =>
          console.error("não foi possivel realizar o login:" + error)
        );
    }
  }
};
</script>