import Vue from 'vue'

Vue.filter('secondsToDays', function (seconds) {
  var d = Math.floor(seconds / (3600*24));
  var h = Math.floor(seconds % (3600*24) / 3600);
  var m = Math.floor(seconds % 3600 / 60);
  var s = Math.floor(seconds % 60);

  if (s < 10) s = '0' + s
  if (m < 10) m = '0' + m

  return `${d} days ${h}:${m}:${s}`
})
