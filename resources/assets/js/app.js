require('./bootstrap');

import VueRouter from "vue-router"

Vue.use(VueRouter)
Vue.config.debug = true;

const router = new VueRouter({
  history: true
})

import MainPage from './components/MainPage.vue'
import SelectTestPage from './components/SelectTestPage.vue'
import TestPage from './components/TestPage.vue'

var App = Vue.extend({})

router.map({
  '/': {
    component: MainPage
  },
  '/test': {
    name: 'TestPage',
    component: TestPage
  },
  '/test/select': {
    component: SelectTestPage
  }
})

router.start(App, "#app")
