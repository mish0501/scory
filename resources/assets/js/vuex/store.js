import Vue from 'vue'
import Vuex from 'vuex'
import test from './test/store'
import createLogger from 'vuex/logger'

Vue.use(Vuex)
Vue.config.debug = true

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  modules: {
    test
  },
  strict: debug,
  middlewares: debug ? [createLogger()] : []
})
