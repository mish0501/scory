<template>
  <div>
    <h1>TestPage</h1>
  </div>
</template>

<script>
import { Questions } from "../vuex/test/getters.js"
export default {
  vuex: {
    getters: {
      questions: Questions
    }
  },

  ready(){
    console.log(this.questions);
  }
}
</script>
