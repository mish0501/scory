import Vue from 'vue'
import Vuex from 'vuex'
import * as actions from './actions'
import * as getters from './getters'
import test from './modules/test'
import user from './modules/user'
import lesson from './modules/lesson'
import createLogger from 'vuex/dist/logger'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  actions,
  getters,
  modules: {
    test,
    user,
    lesson
  },
  strict: debug,
  middlewares: debug ? [createLogger()] : []
})
