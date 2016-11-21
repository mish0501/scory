<template lang="html">
  <div class='row' id='content-wrapper'>
      <router-view></router-view>
  </div>
</template>

<script>
export default {
  beforeCreate () {
    this.$http.get('/api/user').then((response) => {
      this.$store.dispatch('set_user', response.data)
    }, (error) => {
      console.error(error);
    })
  }
}
</script>

<style lang="css">
</style>
