import App from './pages/App'
import router from './router'
import store from './vuex/store' // vuex store instance
import { sync } from 'vuex-router-sync'

sync(store, router)

router.start(App, '#app')
