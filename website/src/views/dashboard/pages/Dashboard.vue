<template>
  <v-container
    id="dashboard"
    fluid
    tag="section"
  >
    <v-row>
      <v-col
        cols="12"
        sm="6"
        lg="3"
      >
        <base-material-stats-card
          color="info"
          icon="mdi-account-group"
          title="Users online"
          :value="`${$store.state.server.online_players} / ${$store.state.server.total_players}`"
        />
      </v-col>

      <v-col
        cols="12"
        sm="6"
        lg="3"
      >
        <base-material-stats-card
          color="primary"
          icon="mdi-poll"
          title="Server version"
          :value="$store.state.server.version"
        />
      </v-col>

      <v-col
        cols="12"
        sm="6"
        lg="3"
      >
        <base-material-stats-card
          color="success"
          icon="mdi-store"
          title="Time passed"
          :value="$store.state.server.time_since_start | secondsToDays"
        />
      </v-col>

      <v-col
        cols="12"
        sm="6"
        lg="3"
      >
        <base-material-stats-card
          color="orange"
          icon="mdi-sofa"
          title="Time left"
          :value="$store.state.server.time_left | secondsToDays"
        />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import ItemIcon from "../components/custom/ItemIcon";
  export default {
    name: 'DashboardDashboard',
    components: {ItemIcon},
    data () {
      return {}
    },

    computed: {

    },

    methods: {

    },
  }
</script>
