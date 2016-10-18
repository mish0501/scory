import MainPage from './components/MainPage.vue'
import SelectTestPage from './components/SelectTestPage.vue'
import TestPage from './components/TestPage.vue'

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
var router = new VueRouter({
  history: true
})

router.map({
  '/': {
    name: 'MainPage',
    component: MainPage
  },
  '/test': {
    name: 'TestPage',
    component: TestPage
  },
  '/test/select': {
    component: SelectTestPage
  }
})

export default router
