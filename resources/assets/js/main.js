require('./bootstrap');

import router from './router'
import store from './vuex/store' // vuex store instance
import { sync } from 'vuex-router-sync'
import MessegesWidget from './components/AdminPages/MessegesWidget.vue'

// sync(store, router)

Vue.component('messeges-widget', MessegesWidget)

var App = new Vue({
  store,
  router
}).$mount('#app')
