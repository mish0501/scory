require('./bootstrap');

import router from './router'
import store from './vuex/store'
import MessegesWidget from './components/AdminPages/MessegesWidget.vue'
import Loading from './components/Loading.vue'

Vue.component('messeges-widget', MessegesWidget)
Vue.component('loading', Loading)

var App = new Vue({
  store,
  router
}).$mount('#app')
