import Vue from 'vue'

Vue.filter('localizedDatetime', function (datetime) {
  var date = new Date(datetime);
  return date.toLocaleString()
})
