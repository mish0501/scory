require('./bootstrap');

import VueRouter from "vue-router"

Vue.use(VueRouter)
Vue.config.debug = true;

const router = new VueRouter()

import MainPage from './components/MainPage.vue'
import TestPage from './components/TestPage.vue'

var App = new Vue({
  el: "#app",
  components: {
    'main-page': MainPage,
    'test-page': TestPage
  }
})
