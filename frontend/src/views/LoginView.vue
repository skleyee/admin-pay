<template>
  <form>

    <div class="form-group mb-3">
      <label for="login">Login</label>
      <input
          v-model="login"
          type="login"
          class="form-control"
          id="login"
          placeholder="Enter login">
      <div v-if="errors.login" class="text-danger">{{ errors.login }}</div>
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Password</label>
      <input
          v-model="password"
          type="password"
          class="form-control"
          id="exampleInputPassword1"
          placeholder="Password">
      <div v-if="errors.password" class="text-danger">{{ errors.password }}</div>
    </div>
    <button
        type="submit"
        class="mt-3 btn btn-primary"
        @click.prevent="signIn"
    >Submit</button>
  </form>
</template>

<script>
import api from "../api/api";
import { mapActions, mapGetters } from 'vuex';
import router from "@/router";

export default {
  name: "LoginView",

  data() {
    return {
      login: "",
      password: "",
      errors: {}
    }
  },

  methods: {
    ...mapActions(['saveAuthToken']),
    validate() {
      this.errors = {};
      let valid = true;

      if (!this.login) {
        this.errors.login = "Login is required.";
        valid = false;
      }

      if (!this.password) {
        this.errors.password = "Password is required.";
        valid = false;
      } else if (this.password.length < 6) {
        this.errors.password = "Password must be at least 6 characters long.";
        valid = false;
      }

      return valid;
    },
    signIn() {
      if (!this.validate() || this.authToken) {
        return;
      }

      api.post("http://localhost:8000/api/sign-in", {
        'login': this.login,
        'password': this.password
      })
        .then((response) => {
          if (response.data.success) {
            const token = response.data.token;
            this.saveAuthToken(token);
            router.push({ name: "users" });
          }
        })
        .catch(function (error) {
          console.error(error);
          alert(error)
        });
    }
  },
  computed: {
    ...mapGetters(['authToken']),
  }
}
</script>

<style scoped>

</style>