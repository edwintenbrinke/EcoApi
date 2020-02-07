<template>
  <v-container
    id="regular-forms"
    fluid
    tag="section"
  >
    <v-col cols="12">
      <base-material-card
        color="primary"
        icon="mdi-cart"
        :title="this.$t('nav.trades')"
        class="px-5 py-3"
      >
        <v-col>
          <v-card-title>
            <v-spacer />
            <search-text-field :value.sync="search" />
          </v-card-title>
          <v-data-table
            class="pa-5"
            :loading="loading"
            :headers="headers"
            :options.sync="options"
            :items="data"
            :server-items-length="totalItems"
            :multi-sort="true"
          >
            <template v-slot:item.buying="{ item }">
              {{ item.buying ? "Buying" : "Selling" }}
            </template>
            <template v-slot:item.created_at="{ item }">
              {{ item.created_at | localizedDatetime }}
            </template>
            <template v-slot:no-results>
              <v-alert
                :value="true"
                color="error"
                icon="warning"
              >
                Your search for "{{ search }}" found no results.
              </v-alert>
            </template>
          </v-data-table>
        </v-col>
      </base-material-card>
    </v-col>
  </v-container>
</template>

<script>
  import SearchTextField from '@/views/dashboard/components/custom/SearchTextField'
  export default {
    components: { SearchTextField },
    data: () => ({
      search: '',
      headers: [
        { text: 'Item name', value: 'name', search: true },
        { text: 'Buying | Selling', value: 'buying', search: false },
        { text: 'Price', value: 'price', search: false },
        { text: 'Amount', value: 'max_num_wanted', search: false },
        { text: 'Shop name', value: 'store_name', search: false },
        { text: 'Username', value: 'user_name', search: true },
        { text: 'Currency', value: 'currency_name', search: false }
      ],
      data: [],
      options: {},
      totalItems: 0,
      loading: true,
    }),

    computed: {
      params () {
        return {
          ...this.options,
          query: this.search,
          fields: this.headers,
        }
      },
    },
    watch: {
      params: {
        handler () {
          this.getDataFromApi()
        },
        deep: true,
      },
    },
    methods: {
      async getDataFromApi () {
        this.loading = true
        let response = await this.$http.get('/api/offers', { params: { options: this.params } })
        this.data = response.data.items
        this.totalItems = response.data.total_items_count
        this.loading = false
      },
    },
  }
</script>

<style scoped>

</style>
