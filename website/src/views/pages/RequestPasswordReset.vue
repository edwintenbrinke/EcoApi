<template>
  <v-container
    id="login"
    class="fill-height"
    tag="section"
  >
    <v-row justify="center">
      <v-slide-y-transition appear>
        <base-material-card
          color="primary"
          light
          max-width="100%"
          width="400"
          class="px-5 py-3"
        >
          <template v-slot:heading>
            <div class="text-center">
              <h1 class="display-2 font-weight-bold mb-2">
                Password reset
              </h1>
            </div>
          </template>

          <v-card-text class="text-center">
            <v-text-field
              v-model="email"
              prepend-icon="mdi-email"
              name="email"
              label="E-mail"
              type="text"
              class="mb-8"
              required
              :rules="validate.email"
              @keyup.enter="submit"
            />

            <pages-btn
              md12
              large
              color=""
              depressed
              class="v-btn--text primary--text"
              @click="submit"
            >
              Submit
            </pages-btn>
          </v-card-text>
        </base-material-card>
      </v-slide-y-transition>
    </v-row>
  </v-container>
</template>
<script>
  import validation from '@/utils/validation'

  export default {
    name: 'RequestPasswordReset',

    components: {
      PagesBtn: () => import('./components/Btn'),
    },
    data: function () {
      return {
        validate: validation,
        email: '',
        error: {
          message: '',
        },
      }
    },
    methods: {
      submit: function () {
        this.$http.post(
          'password/reset',
          { email: this.email }
        ).then((response) => {
          this.$toasted.global.success(response.data.message)
          this.$router.push({ name: 'Login' })
        })
      },
    },
  }
</script>

<style>
</style>
