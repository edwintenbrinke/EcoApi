import Vue from 'vue'

import router from '@/router/router'
import store from '@/store'
import CookieHelper from '@/helpers/CookieHelper'

Vue.prototype.$_logout = function (message = `Your session has expired, please login again`) {
  if (message) { Vue.prototype.$toasted.global.error(message) }

  store.commit('setAuth', false)
  store.commit('setAdmin', false)

  CookieHelper.unsetCookie('user')

  router.push({ name: 'Login' })
}
