import MainPage from './components/MainPage.vue'
import SelectTestPage from './components/SelectTestPage.vue'
import TestPage from './components/TestPage.vue'
import CheckTestPage from './components/CheckTestPage.vue'
import AdminPage from './components/AdminPage.vue'
import AdminHomePage from './components/AdminPages/AdminHomePage.vue'

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  { path: '/', name: 'MainPage', component: MainPage },

  { path: '/test', name: 'TestPage', component: TestPage },

  { path: '/test/select', component: SelectTestPage },

  { path: '/test/check', component: CheckTestPage },

  { path: '/admin', component: AdminPage,
    children: [
      { path: 'home', component: AdminHomePage   },
      { path: 'subject', component: AdminHomePage }
    ]
  }
]

var router = new VueRouter({
  mode: 'history',
  routes,
  linkActiveClass: "active"
})

export default router
