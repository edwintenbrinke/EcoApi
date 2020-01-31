import Vue from 'vue'
import Router from 'vue-router'
import routerPaths from '@/router/router_paths'
import CookieHelper from '../helpers/CookieHelper'
import store from '@/store'

Vue.use(Router)

const router = new Router({
  mode: 'hash',
  base: process.env.BASE_URL,
  routes: routerPaths,
})

// validate admin & authentication each route change
router.beforeEach((to, from, next) => {
  store.commit('setAuth', CookieHelper.checkLogin())
  store.commit('setAdmin', CookieHelper.checkAdmin())

  // console.log(to.meta.authRequired, !store.state.authenticated, to.name);
  if (to.meta.authRequired && !store.state.authenticated && to.name !== 'Login') next('/page/login')
  else if (to.meta.admin && !store.state.admin) next('/')
  else next()
})

export default router
