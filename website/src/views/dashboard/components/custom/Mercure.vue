<template />

<script>
  import { EventSourcePolyfill } from 'event-source-polyfill'

  export default {
    name: 'Mercure',
    async created () {
      let response = await this.getToken()
      const url = new URL('https://gmyb02.stackhero-network.com/hub')
      url.searchParams.append('topic', 'test')
      const eventSource = new EventSourcePolyfill(url, {
        headers: {
          'Authorization': response.data.token,
        },
      })
      eventSource.onmessage = e => console.log(e)// this.onMessage
    },

    methods: {
      async getToken () {
        return this.$http.get('/login/mercure/token')
      },
    },
  }
</script>

<style scoped>

</style>
