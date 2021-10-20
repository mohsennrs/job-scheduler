<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#"> {{ this.$auth.loggedIn?this.$auth.user.name:'' }}</a>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
          </li>
          <button class="btn btn-outline-success my-2 my-sm-0" type="button" @click="logout" v-if="this.$auth.loggedIn">Logout</button>
          <a href = "/login" class="btn btn-outline-success my-2 my-sm-0" type="button" v-else>Login</a>
        </ul>
      </div>
    </nav>
    <Nuxt />
  </div>
</template>
<script>

export default {
  methods: {
    async logout () {
      await this.$auth.logout()
    }
  }
}
</script>
