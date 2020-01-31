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
              v-model="password"
              prepend-icon="mdi-lock-outline"
              name="password"
              label="Password"
              type="password"
              :rules="validate.text"
              @keyup.enter="submit"
            />
            <v-text-field
              id="password"
              v-model="password_copy"
              prepend-icon="mdi-lock-outline"
              name="password_copy"
              label="Password verfication"
              type="password"
              :rules="validate.text"
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
    name: 'PasswordReset',

    components: {
      PagesBtn: () => import('./components/Btn'),
    },
    data: function () {
      return {
        validate: validation,
        password: '',
        password_copy: '',
        error: {
          message: '',
        },
      }
    },
    methods: {
      submit: function () {
        if (this.password !== this.password_copy) {
          this.$toasted.global.error('Passwords are not identical')
          return
        }

        this.$http.post(
          `password/reset/${this.$route.params.id}`,
          { password: this.password }
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
