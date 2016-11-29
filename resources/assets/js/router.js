import MainPage from './components/MainPage.vue'
import SelectTestPage from './components/SelectTestPage.vue'
import TestPage from './components/TestPage.vue'
import CheckTestPage from './components/CheckTestPage.vue'
import JoinTestroomPage from './components/Testroom/Join.vue'

import AdminPage from './components/AdminPage.vue'
import AdminHomePage from './components/AdminPages/HomePage.vue'
import AdminTrashPage from './components/AdminPages/TrashPage.vue'

import AdminSubjectsPage from './components/AdminPages/Subjects/Index.vue'
import AdminCreateSubjectsPage from './components/AdminPages/Subjects/Create.vue'
import AdminEditSubjectsPage from './components/AdminPages/Subjects/Edit.vue'

import AdminParitionsPage from './components/AdminPages/Partitions/Index.vue'
import AdminCreateParitionsPage from './components/AdminPages/Partitions/Create.vue'
import AdminEditParitionsPage from './components/AdminPages/Partitions/Edit.vue'

import AdminQuestionsPage from './components/AdminPages/Questions/Index.vue'
import AdminCreateQuestionsPage from './components/AdminPages/Questions/Create.vue'
import AdminEditQuestionsPage from './components/AdminPages/Questions/Edit.vue'

import AdminTestroomsPage from './components/AdminPages/Testrooms/Index.vue'
import AdminTestroomCreatePage from './components/AdminPages/Testrooms/Create.vue'
import AdminTestroomActivatePage from './components/AdminPages/Testrooms/Activate.vue'

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  { path: '/', name: 'MainPage', component: MainPage },

  { path: '/test', name: 'TestPage', component: TestPage },

  { path: '/test/select', component: SelectTestPage },

  { path: '/test/check', component: CheckTestPage },

  {path: '/testroom/:code/join', component:JoinTestroomPage, name:"JoinTestroom" },

  { path: '/admin', component: AdminPage,
    children: [
      { path: 'home', component: AdminHomePage },
      { path: 'trash', component: AdminTrashPage },

      // Subjects
      { path: 'subject', component: AdminSubjectsPage },
      { path: 'subject/create', component: AdminCreateSubjectsPage },
      { path: 'subject/:id/edit', component: AdminEditSubjectsPage, name:'EditSubject' },

      // Partitions
      { path: 'partition', component: AdminParitionsPage },
      { path: 'partition/create', component: AdminCreateParitionsPage },
      { path: 'partition/:id/edit', component: AdminEditParitionsPage, name:'EditPartition' },

      // Questions
      { path: 'question', component: AdminQuestionsPage },
      { path: 'question/create', component: AdminCreateQuestionsPage },
      { path: 'question/:id/edit', component: AdminEditQuestionsPage, name:'EditQuestion' },

      // Testroom
      { path: 'testroom', component: AdminTestroomsPage },
      { path: 'testroom/create', component: AdminTestroomCreatePage },
      { path: 'testroom/:code/active', component: AdminTestroomActivatePage, name:'ActivateTestroom' }
    ]
  }
]

var router = new VueRouter({
  mode: 'history',
  routes,
  linkActiveClass: "active"
})

export default router
