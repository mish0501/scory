import Vue from 'vue'
import Vuex from 'vuex'
import cart from './cart/store'
import products from './products/store'
import createLogger from 'vuex/logger'

Vue.use(Vuex)
Vue.config.debug = true

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  modules: {
    cart,
    products
  },
  strict: debug,
  middlewares: debug ? [createLogger()] : []
})
