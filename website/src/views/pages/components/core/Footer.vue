<template>
  <v-footer
    id="pages-core-footer"
    absolute
    color="transparent"
    dark
  >
    <v-container>
      <v-row
        align="center"
        no-gutters
      >
        <v-spacer class="hidden-sm-and-down" />

        <v-col
          cols="12"
          md="auto"
        >
          <div class="body-1 font-weight-light pt-6 pt-md-0 text-center">
            &copy; 2019,
            <a
              :href="links[0].href"
              class="mr-0"
              rel="noopener"
              target="_blank"
              v-text="links[0].text"
            />
          </div>
        </v-col>
      </v-row>
    </v-container>
  </v-footer>
</template>

<script>
  export default {
    name: 'PagesCoreFooter',

    data: () => ({
      links: [
        {
          href: 'https://www.edwintenbrinke.nl/',
          text: 'Edwin ten Brinke',
        },
      ],
    }),
  }
</script>

<style lang="sass">
  #pages-core-footer
    a
      color: #FFFFFF
      font-size: .825rem
      font-weight: 500
      text-decoration: none
      text-transform: uppercase
</style>
