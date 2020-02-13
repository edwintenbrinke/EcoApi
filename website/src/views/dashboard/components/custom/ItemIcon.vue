<template>
  <v-img :src="icon_url" max-width="25" max-height="25" @click="checkUpdate"/>
</template>

<script>
  export default {
    name: 'ItemIcon',
    props: {
      value: {
        type: Object,
        required: true,
      }
    },
    data() {
      return {
        icon_url: 'https://gamepedia.cursecdn.com/eco_gamepedia/5/51/NoImage.png'
      }
    },
    mounted() {
      if (this.value.icon) {
        this.icon_url = this.value.icon;
      }
    },
    computed: {
      item_name() {
        return this.value.name.split(' ').join('_')
      },
    },
    methods: {
      checkUpdate() {
        this.$http.post(`/api/item/${this.value.id}/icon`, {item_name: this.item_name})
          .then(response => {
            this.icon_url = response.data.icon_url;
          })
      }
    }
  }
</script>

<style scoped>

</style>
