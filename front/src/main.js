import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import HighchartsVue from 'highcharts-vue'

//axios.defaults.baseURL = 'http://192.168.3.54/Layers/back/';
console.log(window.location.origin.split(':')[0]+window.location.origin.split(':')[1]);
axios.defaults.baseURL = window.location.origin.split(':')[0]+':'+window.location.origin.split(':')[1] +'/Layers/back/';
createApp(App).use(store).use(router).use(HighchartsVue).mount('#app')
