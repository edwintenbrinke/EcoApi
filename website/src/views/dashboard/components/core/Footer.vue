<template>
  <v-footer
    id="dashboard-core-footer"
  >
    <v-container>
      <v-row
        align="center"
        no-gutters
      >
        <v-col
          v-for="(language, i) in languages"
          :key="i"
          cols="auto"
        >
          <span
            style="padding:5px;"
            @click="changeCountry(language.file)"
          >
            <country-flag
              :country="language.flag"
              size="small"
            />
          </span>
        </v-col>

        <v-spacer class="hidden-sm-and-down" />

        <v-col
          cols="12"
          md="auto"
        >
          <div class="body-1 font-weight-light pt-6 pt-md-0 text-center">
            &copy; 2019,
            <a href="https://www.edwintenbrinke.nl/">Edwin ten Brinke</a>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </v-footer>
</template>

<script>
  export default {
    name: 'DashboardCoreFooter',

    data: () => ({
      languages: [
        {
          file: 'nl',
          flag: 'nl',
        },
        {
          file: 'en',
          flag: 'us',
        },
      ],
    }),

    methods: {
      changeCountry: function (country) {
        this.$i18n.locale = country
      },
    },
  }
</script>

<style lang="sass">
  #dashboard-core-footer
    a
      color: #3c4858
      font-size: .825rem
      font-weight: 500
      text-decoration: none
      text-transform: uppercase
</style>
