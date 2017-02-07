<template lang="html">
  <div id="loading" @click.stop="doNothing()">
    <div class="spinner">
      <div class="logo">
        <img src="/assets/images/logo_bg.svg" alt="">
      </div>
    </div>
    <div class="clear"></div>
  </div>
</template>

<script>
export default {
  name: "Loading",
  methods: {
    doNothing() {
      return false;
    }
  }
}
</script>

<style lang="css">
  #loading {
    display: block;
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
    background-color: rgba(255,255,255,0.8);
  }

  .clear{
    clear: both;
  }

  .spinner{
    width: 100px;
    height: 100px;
    background: #eee;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    left: 50%;
    margin: -50px 0 0 -50px;
    display: block;
  }

  .spinner:after, .spinner:before {
    content: '';
    display: block;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    position: absolute;
    top: 0px;
    left: 0px;
    border: 4px solid transparent;
  }

  .spinner:after{
    border-top-color: #0ad03e;
    border-bottom-color: #0ad03e;
    animation: spinny 1s linear infinite;
  }

  .spinner:before{
    border-top-color: #08c33a;
    border-bottom-color: #08c33a;
    animation: spinny2 1s linear 0.08s infinite;
  }

  @keyframes spinny{
    0% {
      transform: rotate(0deg) scale(1);
    }
    50% {
      transform: rotate(45deg) scale(1.2);
    }
    100%{
      transform: rotate(360deg) scale(1);
    }
  }

  @keyframes spinny2{
    0% {
      transform: rotate(0deg) scale(1);
    }
    50% {
      transform: rotate(45deg) scale(1.305);
    }
    100%{
      transform: rotate(360deg) scale(1);
    }
  }

  #loading .logo{
    width: auto;
    height: auto;
    position: absolute;
    top: 0;
    left: 0;
    padding: 15px
  }

  #loading .logo img {
    width: 100%;
    height: 100%;
  }
</style>
