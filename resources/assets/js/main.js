require('./bootstrap');

import router from './router'
import store from './vuex/store' // vuex store instance
import { sync } from 'vuex-router-sync'

var App = Vue.extend({
  store
})

sync(store, router)

router.start(App, '#app')
