import HomePage from './pages/HomePage'
import ProductPage from './pages/ProductPage'
import CartPage from './pages/CartPage'
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
var router = new VueRouter({
  history: false
})

router.map({
  '/': {
    component: HomePage
  },
  '/product/:id': {
    name: 'product',
    component: ProductPage
  },
  '/cart': {
    component: CartPage
  }
})

export default router
