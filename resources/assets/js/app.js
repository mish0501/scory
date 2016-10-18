require('./bootstrap');

import VueRouter from "vue-router"
import Vuex from "vuex"

Vue.use(VueRouter)
Vue.use(Vuex)
Vue.config.debug = true;

const router = new VueRouter({
  history: true
})

const state = {
  questions: null
}

const mutations = {
  SETQUESTIONS (state, data) {
    state.questions = data
  }
}

const store = new Vuex.Store({
  state,
  mutations
})

import MainPage from './components/MainPage.vue'
import SelectTestPage from './components/SelectTestPage.vue'
import TestPage from './components/TestPage.vue'

var App = Vue.extend({
  store: store
})

router.map({
  '/': {
    name: 'MainPage',
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
