import Vue from 'vue'
import Vuex from 'vuex'
import VuexPersist from 'vuex-persist'

Vue.use(Vuex)

const vuexPersist = new VuexPersist({
  key: 'eco_api',
  storage: window.localStorage
})

export default new Vuex.Store({
  plugins: [vuexPersist.plugin],
  state: {
    barColor: 'rgba(0, 0, 0, .8), rgba(0, 0, 0, .8)',
    barImage: 'https://demos.creative-tim.com/material-dashboard-pro/assets/img/sidebar-1.jpg',
    drawer: null,
    server: null,
    online_users: null,
  },
  mutations: {
    // TEMPLATE
    SET_BAR_IMAGE (state, payload) {
      state.barImage = payload
    },
    SET_DRAWER (state, payload) {
      state.drawer = payload
    },
    SET_SCRIM (state, payload) {
      state.barColor = payload
    },
    // CUSTOM
    setAuth (state, payload) {
      state.authenticated = payload
    },
    setAdmin (state, payload) {
      state.admin = payload
    },
    setChanges (state, payload) {
      state.changes = payload
    },
  },
  actions: {

  },
})
