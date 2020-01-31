import Vue from 'vue'

// Lib imports
import Toasted from 'vue-toasted'

Vue.use(Toasted)

Vue.toasted.register('success',
  (message) => { return message },
  { type: 'success', duration: 7500, position: 'top-center' }
)

Vue.toasted.register('error',
  (message) => { return message },
  { type: 'error', duration: 7500, position: 'top-center' }
)
