<template>
  <form>
    <div class="form-group mb-3">
      <label for="name">Name</label>
      <input
          v-model="name"
          type="name"
          class="form-control"
          id="name"
          placeholder="Enter name"
      >
      <div v-if="errors.name" class="text-danger">{{ errors.name }}</div>
    </div>
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
    <div class="form-group mb-3">
      <label for="exampleInputEmail1">Email address</label>
      <input
          v-model="email"
          type="email"
          class="form-control"
          id="exampleInputEmail1"
          aria-describedby="emailHelp"
          placeholder="Enter email">
      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      <div v-if="errors.email" class="text-danger">{{ errors.email }}</div>
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
        @click.prevent="register"
    >Submit</button>
  </form>
</template>

<script>

import api from "../api/api";
import { mapActions, mapGetters } from 'vuex';
import router from "@/router/index";

export default {
  name: "RegisterView",

  data() {
    return {
      name: "",
      login: "",
      email: "",
      password: "",
      errors: {}
    }
  },

  methods: {
    ...mapActions(['saveAuthToken']),
    validate() {
      this.errors = {};
      let valid = true;

      if (!this.name) {
        this.errors.name = "Name is required.";
        valid = false;
      }

      if (!this.login) {
        this.errors.login = "Login is required.";
        valid = false;
      }

      if (!this.email) {
        this.errors.email = "Email is required.";
        valid = false;
      } else if (!/\S+@\S+\.\S+/.test(this.email)) {
        this.errors.email = "Email is invalid.";
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

    register() {
      console.log(this.name);
      console.log(this.authToken);

      if (!this.validate() || this.authToken) {
        return;
      }

      api.post("sign-up", {
            'name': this.name,
            'login': this.login,
            'email': this.email,
            'password': this.password,
          })
          .then((response) => {
            console.log(response.data);
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