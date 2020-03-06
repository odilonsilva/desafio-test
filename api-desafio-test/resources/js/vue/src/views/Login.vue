<template>
    <div class="login">
        <h1>Login</h1>
        <input type="text" v-model="email" placeholder="Email">
        <br>
        <input type="text" v-model="password" placeholder="Senha">
        <br>
        <button @click="login">Login</button>
    </div>
</template>
<script>
export default {
    name: 'login',
    data(){
        return {
            email: null,
            password: null,
            has_error: false,
        }
    },
    methods:{
        login: function(){
            var app = this
            var redirect = this.$auth.redirect()
            this.$auth.login({
                body: {
                    email: app.email,
                    password: app.password
                },
                success: function(){
                    this.$router.push({name: redirect.from.name})
                }
            })
        }
    }
}
</script>