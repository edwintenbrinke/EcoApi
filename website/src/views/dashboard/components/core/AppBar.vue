<template>
  <v-app-bar
    absolute
    app
    color="transparent"
    flat
    height="75"
    style="width: auto;"
  >
    <v-btn
      fab
      small
      @click="$vuetify.breakpoint.smAndDown ? setDrawer(!drawer) : $emit('input', !value)"
    >
      <v-icon v-if="value">
        mdi-view-quilt
      </v-icon>

      <v-icon v-else>
        mdi-dots-vertical
      </v-icon>
    </v-btn>
    <v-spacer />
    last update: {{ $store.state.server.last_process | localizedDatetime }}
    <v-spacer />

<!--    <v-btn-->
<!--      class="white"-->
<!--      @click="$_logout(null)"-->
<!--    >-->
<!--      <v-icon-->
<!--        left-->
<!--        v-text="logout_icon"-->
<!--      />-->
<!--      Logout-->
<!--    </v-btn>-->
  </v-app-bar>
</template>

<script>
  // Components
  import { VHover, VListItem } from 'vuetify/lib'

  // Utilities
  import { mapState, mapMutations, mapGetters } from 'vuex'

  export default {
    name: 'DashboardCoreAppBar',
    props: {
      value: {
        type: Boolean,
        default: false,
      },
    },

    data: () => ({
      logout_icon: 'mdi-exit-to-app',
    }),

    computed: {
      ...mapState(['drawer']),
    },

    mounted () {
    },

    methods: {
      ...mapMutations({
        setDrawer: 'SET_DRAWER',
      }),
    },
  }
</script>

<style>
  .margin-null {
    margin: 0px 5px;
  }
</style>
