import Vue from 'vue'

Vue.filter('millisecondsToCooldown', function (milliseconds) {
    if (milliseconds <= 1000) return 'now'

    var hours = Math.floor((milliseconds % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
    var minutes = Math.floor((milliseconds % (1000 * 60 * 60)) / (1000 * 60))
    var seconds = Math.floor((milliseconds % (1000 * 60)) / 1000)

    if (seconds < 10) seconds = '0' + seconds
    if (minutes < 10) minutes = '0' + minutes
    let display_hours = ''
    if (hours > 0) {
        display_hours = hours + ':'
    }

    return `${display_hours}${minutes}:${seconds}`
})
