import Vue from 'vue'

Vue.filter('localizedDatetime', function (datetime) {
  var date = new Date(datetime);
  console.log(date, datetime)
  return date.toLocaleString()
})
