<template>
  <div>{{text}}</div>
</template>
<script>
  export default {
    data() {
      return {
        text: ''
      }
    },
    mounted() {
      this.$echo.channel('test-channel')
        .listen('TestEvent', (e) => {
          this.text = 'hello'
        })
    }
  }
</script>
