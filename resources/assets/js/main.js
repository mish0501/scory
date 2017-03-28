require('./bootstrap');

import router from './router'
import store from './vuex/store'
import MessagesWidget from './components/AdminPages/MessagesWidget.vue'
import Loading from './components/Loading.vue'

Vue.component('messages-widget', MessagesWidget)
Vue.component('loading', Loading)

const mixin = {
  methods: {
    can(permission) {
      return this.$store.getters.User.permissions.find((perm) => {
        return perm == permission
      }) === permission
    },

    logout(){
      this.$store.dispatch('clear_store')

      this.$http.post('/logout').then(
        (response) => {
          let url = response.data.url
          window.location = url
        }, console.error
      )
    }
  }
}

Vue.mixin(mixin)

var App = new Vue({
  store,
  router
}).$mount('#app')
