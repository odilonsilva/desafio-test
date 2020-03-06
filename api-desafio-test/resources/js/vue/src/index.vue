<template>
    <router-view />
</template>
<script>
export default {
    name:'Index',
    data(){
        return {}
    }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}
input {
  height: 32px;
  width: 250px;
  margin: 10px auto;
  line-height: 30px;
  font-size: 20px;
}
button {
  width: 110px;
  height: 50px;
  font-size: 20px;
  background: #4d4dde;
  color: #fff;
  border: 1px solid;
}
</style>
