require('./bootstrap');

import router from './router'
import store from './vuex/store'
import MessegesWidget from './components/AdminPages/MessegesWidget.vue'

Vue.component('messeges-widget', MessegesWidget)

var App = new Vue({
  store,
  router
}).$mount('#app')
