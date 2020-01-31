<template>
  <v-text-field
    v-model="search"
    append-icon="mdi-magnify"
    label="Search"
  />
</template>

<script>
  export default {
    name: 'SearchTextField',
    props: {
      value: {
        type: String,
        required: true,
      },
      time: {
        type: Number,
        required: false,
        default: 1000,
      },
    },
    data () {
      return {
        search: '',
        timeout: null,
      }
    },
    watch: {
      search: function () {
        clearTimeout(this.timeout)
        this.timeout = setTimeout(this.stoppedTyping, this.time)
      },
    },
    methods: {
      stoppedTyping () {
        this.$emit('update:value', this.search)
      },
    },
  }
</script>

<style scoped>

</style>
