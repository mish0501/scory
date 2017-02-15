import MainPage from './components/MainPage.vue'
import SelectTestPage from './components/SelectTestPage.vue'
import TestPage from './components/TestPage.vue'
import CheckTestPage from './components/CheckTestPage.vue'

import JoinTestroomPage from './components/Testroom/Join.vue'
import TestroomPage from './components/Testroom/Index.vue'
import TestroomFinishPage from './components/Testroom/Finish.vue'

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
import AdminTestroomStartPage from './components/AdminPages/Testrooms/Start.vue'
import AdminTestroomResultsPage from './components/AdminPages/Testrooms/Results.vue'
import AdminTestroomStudentResultsPage from './components/AdminPages/Testrooms/StudentResults.vue'

import AdminMailPage from './components/AdminPages/Mail/Index.vue'
import AdminShowMailPage from './components/AdminPages/Mail/Show.vue'

import AdminSettingsUsersPage from './components/AdminPages/Settings/Users/Index.vue'
import AdminSettingsEditUsersPage from './components/AdminPages/Settings/Users/Edit.vue'

import AdminSettingsPermissionsPage from './components/AdminPages/Settings/Permissions/Index.vue'
import AdminSettingsCreatePermissionsPage from './components/AdminPages/Settings/Permissions/Create.vue'
import AdminSettingsEditPermissionsPage from './components/AdminPages/Settings/Permissions/Edit.vue'

import AdminSettingsRolesPage from './components/AdminPages/Settings/Roles/Index.vue'
import AdminSettingsCreateRolesPage from './components/AdminPages/Settings/Roles/Create.vue'
import AdminSettingsEditRolesPage from './components/AdminPages/Settings/Roles/Edit.vue'

import AdminInvitesPage from './components/AdminPages/Invites/Index.vue'
import AdminCreateInvitesPage from './components/AdminPages/Invites/Create.vue'

import FileManager from './components/FileManager/Index.vue'

import AdminUsersPage from './components/AdminPages/Users/Show.vue'
import AdminEditUsersPage from './components/AdminPages/Users/Edit.vue'

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  { path: '/', name: 'MainPage', component: MainPage },

  { path: '/test', name: 'TestPage', component: TestPage },

  { path: '/test/select', component: SelectTestPage },

  { path: '/test/check', component: CheckTestPage },

  { path: '/testroom/finish', component: TestroomFinishPage },
  { path: '/testroom/:code/join', component: JoinTestroomPage, name:'JoinTestroom' },
  { path: '/testroom/:code', component: TestroomPage, name:'Testroom' },

  { path: '/file/manager', component: FileManager, name:'FileManager' },

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
      { path: 'testroom/:code/active', component: AdminTestroomActivatePage, name:'ActivateTestroom' },
      { path: 'testroom/:code/start', component: AdminTestroomStartPage, name:'StartTestroom' },
      { path: 'testroom/:code/student/:number', component: AdminTestroomStudentResultsPage, name:'StudentResultsTestroom' },
      { path: 'testroom/:code/results', component: AdminTestroomResultsPage, name:'ResultsTestroom' },

      // Mail
      { path: 'mail', component: AdminMailPage },
      { path: 'mail/:id', component: AdminShowMailPage, name:'ShowMail' },

      // Settings
        // Users
        { path: 'settings/users', component: AdminSettingsUsersPage },
        { path: 'settings/users/:id/edit', component: AdminSettingsEditUsersPage, name:'SettingsEditUser' },

        // Permissions
        { path: 'settings/permissions', component: AdminSettingsPermissionsPage },
        { path: 'settings/permissions/create', component: AdminSettingsCreatePermissionsPage },
        { path: 'settings/permissions/:id/edit', component: AdminSettingsEditPermissionsPage, name:'SettingsEditPermission' },

        // Roles
        { path: 'settings/roles', component: AdminSettingsRolesPage },
        { path: 'settings/roles/create', component: AdminSettingsCreateRolesPage },
        { path: 'settings/roles/:id/edit', component: AdminSettingsEditRolesPage, name:'SettingsEditRole' },

      // Invites
      { path: 'invite', component: AdminInvitesPage },
      { path: 'invite/create/:id?', component: AdminCreateInvitesPage, name: 'CreateInvite' },

      // Users
      { path: 'user/edit', component: AdminEditUsersPage, name: 'UserEdit' },
      { path: 'user/:id', component: AdminUsersPage }
    ]
  }
]

var router = new VueRouter({
  mode: 'history',
  routes,
  linkActiveClass: "active"
})

export default router
