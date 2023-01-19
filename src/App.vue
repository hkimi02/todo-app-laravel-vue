<template>
    <nav class="navbar navbar-expand-lg bg-light shadow-lg" v-if="store.IsAuth">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">todoapp</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <router-link class="nav-link active" aria-current="page" to="/home">Home</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/about">add task</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/categoriesManager">manage categories</router-link>
        </li>
        <li class="nav-item" @click="logout()" v-if="store.IsAuth">
            logout
        </li>
      </ul>
    </div>
  </div>
</nav>
  
  <router-view/>
</template>
<script>
import { useAuthStore } from '@/store/auth.store';
export default{
    data(){
      return{

      }
    },
    methods:{
        logout(){
          this.store.logout();
          this.$router.push('/');
        }
    },
    setup(){
          const store=useAuthStore();
          return {
            store
          }
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

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>
