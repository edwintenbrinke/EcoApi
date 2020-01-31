<template>
  <v-app>
    <vue-progress-bar />

    <dashboard-core-app-bar v-model="expandOnHover" />

    <dashboard-core-drawer :expand-on-hover.sync="expandOnHover" />

    <dashboard-core-view />

    <!--    <dashboard-mercure />-->
  </v-app>
</template>

<script>
  export default {
    name: 'DashboardIndex',

    components: {
      DashboardCoreAppBar: () => import('./components/core/AppBar'),
      DashboardCoreDrawer: () => import('./components/core/Drawer'),
      DashboardCoreView: () => import('./components/core/View'),
      DashboardMercure: () => import('./components/custom/Mercure'),
    },

    data: () => ({
      expandOnHover: false,
    }),

    mounted() {
      this.$http.get('/api/server')
        .then(response => {
          this.$store.state.server = response.data;
        })
    }
  }
</script>
