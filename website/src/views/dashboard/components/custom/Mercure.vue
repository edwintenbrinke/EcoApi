<template />

<script>
  import { EventSourcePolyfill } from 'event-source-polyfill'

  export default {
    name: 'Mercure',
    async created () {
      // let response = await this.getToken()
      // const url = new URL('https://gmyb02.stackhero-network.com/hub')
      // url.searchParams.append('topic', 'test')
      // const eventSource = new EventSourcePolyfill(url, {
      //   headers: {
      //     'Authorization': response.data.token,
      //   },
      // })
      // eventSource.onmessage = e => console.log(e)// this.onMessage
      this.getData()
      this.interval = setInterval(() => this.getData(), 61000);
    },

    methods: {
      async getToken () {
        // return this.$http.get('/login/mercure/token')
      },
      getData() {
        this.$http.get('/api/server')
          .then(response => {
            this.$store.state.server = response.data.server;
            this.$store.state.online_users = response.data.users;
          })
      }
    },
  }
</script>

<style scoped>

</style>
