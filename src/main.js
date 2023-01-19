import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.bundle'
import 'bootstrap-icons/font/bootstrap-icons.css'
import bootstrap from 'bootstrap/dist/js/bootstrap.bundle'
import { createPinia } from 'pinia'


const pinia = createPinia()
createApp(App).use(store).use(router).use(pinia).use(bootstrap).mount('#app');