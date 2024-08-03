<template>
  <div class="container">
    <header
        class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom"
    >
      <a
          href="/"
          class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none"
      >
        <svg
            class="bi me-2"
            width="40"
            height="32"
            role="img"
            aria-label="Bootstrap"
        >
          <use xlink:href="#bootstrap"></use>
        </svg>
      </a>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li>
          <router-link class="nav-link px-2 link-dark" :to="{ name: 'users' }"
          >Users</router-link
          >
        </li>
        <li>
          <router-link
              class="nav-link px-2 link-dark"
              :to="{ name: 'payments' }"
          >Payments</router-link>
        </li>
      </ul>

      <div v-if="!authToken" class="col-md-3 text-end">
        <router-link
            :to="{ name: 'login' }"
            type="button"
            class="btn btn-outline-primary me-2"
        >
          Login
        </router-link>
        <router-link
            :to="{ name: 'register' }"
            type="button"
            class="btn btn-primary"
        >
          Sign-up
        </router-link>
      </div>
      <div v-else>
        <router-link
            :to="{ name: 'login' }"
            type="button"
            class="btn btn-primary"
            @click="removeAuthToken"
        >
          Logout
        </router-link>
      </div>
    </header>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  name: "HeaderBlock",
  methods: {
    ...mapActions(['removeAuthToken']),
  },
  computed: {
    ...mapGetters(['authToken']),
  }
}
</script>

<style scoped>

</style>