<template lang="html">
  <div class='row' id='content-wrapper'>
      <loading v-if="isLoading"></loading>
      <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'AdminWrapper',
  beforeCreate () {
    this.$http.get('/api/user').then((response) => {
      this.$store.dispatch('set_user', response.data)
    }, (error) => {
      console.error(error);
    })
  },
  data () {
    return {
      isLoading: false,
    }
  }
}
</script>

<style lang="css">
</style>
