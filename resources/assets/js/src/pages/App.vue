<template>
<div class="app">
  <div class="header">
  <header-bar></header-bar>
  </div>
  <div class="page">
    <router-view></router-view>
  </div>
</div>
</template>

<script>
  import store from '../vuex/store'
  import HeaderBar from '../components/HeaderBar'
  export default {
    store,
    components: {HeaderBar}
  }
</script>

<style>
html {
}
body {
  font-family: "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
  color: #333;
}
.app {
  display: flex;
  flex-direction: column;
  width: 100%;
}

.header {
  border-bottom: 1px solid #b3b3b3;
  width: 100%;
  padding: 30px 50px;
}

.page {
  width: 100%;
  padding: 30px 50px;
}
</style>
