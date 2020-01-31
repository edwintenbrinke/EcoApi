import Vue from 'vue'
import store from '@/store'

// Lib imports
import axios from 'axios'

Vue.prototype.$http = axios.create( // Base URL is set in App.vue because process.env is not available here
  {
    baseURL: process.env.VUE_APP_BASE_URL_API,
    withCredentials: true,

    // http call progression
    onUploadProgress: function (progressEvent) {
      Vue.prototype.$Progress.set(Math.floor((progressEvent.loaded * 100) / progressEvent.total))
    },
    // http call progression
    onDownloadProgress: function (progressEvent) {
      Vue.prototype.$Progress.set(Math.floor((progressEvent.loaded * 100) / progressEvent.total))
    },
  }
)

Vue.prototype.$http.interceptors.response.use(
  function (response) {
    Vue.prototype.$Progress.finish()
    return response
  },
  function (error) {
    Vue.prototype.$Progress.fail()

    // if (error.message === 'Network Error') {
    //   Vue.prototype.$_logout('The site is currently unavailable, try again later.')
    // }
    //
    // if (
    //   error.response.status === 400 ||
    //   error.response.status === 404 ||
    //   error.response.status === 409
    // ) {
    //   Vue.prototype.$toasted.global.error(error.response.data.message)
    // }
    //
    // if (error.response.status === 401 && error.response.data.message === 'Expired JWT Token') {
    //   Vue.prototype.$_logout()
    // }
    //
    // if (error.response.status === 500) {
    //   Vue.prototype.$toasted.global.error('Something went wrong. If this consists, please contact the site admin')
    // }

    return Promise.reject(error)
  }
)
