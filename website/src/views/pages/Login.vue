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
                Login
              </h1>
            </div>
          </template>

          <v-card-text class="text-center">
            <v-text-field
              v-model="username"
              label="Username..."
              prepend-icon="mdi-account"
              :rules="validate.text"
              @keyup.enter="signIn"
            />

            <v-text-field
              v-model="password"
              type="password"
              class="mb-8"
              label="Password..."
              prepend-icon="mdi-lock-outline"
              :rules="validate.text"
              @keyup.enter="signIn"
            />

            <pages-btn
              color=""
              depressed
              class="v-btn--text primary--text"
              @click="$router.push({ name: 'request_password_reset' })"
            >
              Wachtwoord vergeten?
            </pages-btn>

            <pages-btn
              large
              color=""
              depressed
              class="v-btn--text primary--text"
              @click="signIn"
            >
              Login
            </pages-btn>
          </v-card-text>
        </base-material-card>
      </v-slide-y-transition>
    </v-row>
  </v-container>
</template>

<script>
  import CookieHelper from '@/helpers/CookieHelper'
  import validation from '@/utils/validation'

  export default {
    name: 'PagesLogin',

    components: {
      PagesBtn: () => import('./components/Btn'),
    },

    data: () => ({
      validate: validation,
      username: '',
      password: '',
      error: {
        status: false,
        message: '',
      },
    }),

    methods: {
      signIn: function () {
        this.$store.commit('setAuth', true)
        this.$store.commit('setAdmin', CookieHelper.checkAdmin())
        this.$router.push({ name: 'dashboard' })
        return

        this.$http.post(
          'token/portal/login',
          { username: this.username, password: this.password }
        ).then((response) => {
          this.$store.commit('setAuth', true)
          this.$store.commit('setAdmin', CookieHelper.checkAdmin())
          this.$router.push({ name: 'dashboard' })
        }).catch((error) => {
          this.error.status = true
          this.error.message = error.response.data.message
        })
      },
    },
  }
</script>
