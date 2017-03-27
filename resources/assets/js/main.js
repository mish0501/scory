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
    }
  }
}

Vue.mixin(mixin)

let dataTable;

Vue.directive('data-table', {
  // componentUpdated(el) {

  //   if(dataTable){
  //     console.log(dataTable)
  //     dataTable.fnDestroy()
  //   }

  //   if(!dataTable){
  //     dataTable = $(el).dataTable({
  //       sPaginationType: "bootstrap",
  //       fnDrawCallback () {
  //         return $(".dataTables_wrapper").addClass("scrollable-area");
  //       }
  //     })
  //   }
  // }
})

var App = new Vue({
  store,
  router
}).$mount('#app')
