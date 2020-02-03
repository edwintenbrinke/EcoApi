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
    <v-card
      class="margin-null v-card--plan pb-2 px-2 text-center"
      max-width="100%"
    >
      <div
        class="body-2"
        v-text=""
      />
      <span class="text-uppercase grey--text">time passed:</span> {{ $store.state.server.time_since_start | secondsToDays }}<br>
      <span class="text-uppercase grey--text">time left:</span> {{ $store.state.server.time_left | secondsToDays }}
    </v-card>
    <v-card
      class="margin-null v-card--plan pb-2 px-2 text-center"
      max-width="100%"
    >
      <div
        class="body-2 grey--text"
        v-text="$store.state.server.name"
      />
      {{ $store.state.server.version }}
    </v-card>

    <v-card
      class="margin-null v-card--plan pb-2 px-2 text-center"
      max-width="100%"
    >
      <div
        class="body-2 text-uppercase grey--text"
        v-text="`users online`"
      />
      {{ $store.state.server.online_players }} / {{ $store.state.server.total_players }}
    </v-card>
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
