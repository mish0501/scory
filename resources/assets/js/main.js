require('./bootstrap');

import router from './router'
import store from './vuex/store'
import MessagesWidget from './components/AdminPages/MessagesWidget.vue'
import Loading from './components/Loading.vue'

Vue.component('messages-widget', MessagesWidget)
Vue.component('loading', Loading)

var App = new Vue({
  store,
  router
}).$mount('#app')
