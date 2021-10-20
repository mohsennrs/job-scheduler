<template>
  <div class="container mt-5">
    <h1>Login</h1>
    <form v-on:submit.prevent="login">
        <div class="form-group">
          <input type="text" placeholder="Email" class="form-control form-control-sm" v-model="email">
        </div>
        <div class="form-group">
          <input type="password" placeholder="Password" class="form-control form-control-sm" v-model="password">
        </div>
        <div class="form-group">
          <button class="btn btn-primary">Submit</button>
        </div>
    </form>
  </div>
</template>
<script>
  export default {
    auth: 'guest',
    data() {
      return {
        email : '',
        password : ''
      }
    },
    methods: {
      login() {
        this.$auth.loginWith('laravelSanctum', {
            data: {
              email: this.email,
              password: this.password
            }
          })
      }

    }
  }
</script>
